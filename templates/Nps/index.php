<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NPS from Sentiments</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 24px;
        background-color: #f9f9f9;
    }

    h1 {
        font-size: 3rem;
        font-weight: 600;
        color: #333;
    }

    label {
        font-weight: 500;
        font-size: 1rem;
    }

    input.form-control,
    select.form-select {
        font-size: 1.5rem;
        padding: 8px;
        border-radius: 5px;
    }

    button.btn {
        font-size: 1.5rem;
        padding: 6px;
        border-radius: 10px;
    }

    #nps-result {
        font-weight: bold;
        text-align: center;
        background-color: #e9f5ec;
        border: 1px solid #28a745;
    }

    .container {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Net Promoter Score Analysis</h1>

        <!-- NPS Form -->
        <?= $this->Form->create(null, [
            'type'  => 'post',
            'class' => 'row g-3',
            'id'    => 'nps-form'
        ]) ?>

        <!-- Branch and Date Picker Row -->
        <div class="row mb-4">
            <!-- Branch Dropdown -->
            <div class="col-md-6">
                <?= $this->Form->control('branch', [
                    'type'    => 'select',
                    'options' => $branches,
                    'empty'   => '— Select Branch —',
                    'label'   => 'Hospital Branch',
                    'value'   => $selectedBranch,
                    'class'   => 'form-select',
                    'id'      => 'branch'
                ]) ?>
            </div>

            <!-- Date Picker (Year and Month only) -->
            <div class="col-md-6">
                <?= $this->Form->control('date', [
                    'type'  => 'month', 
                    'label' => 'Analysis Year & Month',
                    'value' => $selectedDate,
                    'class' => 'form-control',
                    'id'    => 'date'
                ]) ?>
            </div>
        </div>

        <!-- Counts Row (Positive, Neutral, Negative) -->
        <div class="row mb-4">
            <!-- Positive Count -->
            <div class="col-md-4">
                <?= $this->Form->control('positive', [
                    'type'     => 'number',
                    'label'    => 'Positive Responses',
                    'readonly' => true,
                    'value'    => $positiveCount ?? 0,
                    'class'    => 'form-control'
                ]) ?>
            </div>

            <!-- Neutral Count -->
            <div class="col-md-4">
                <?= $this->Form->control('neutral', [
                    'type'     => 'number',
                    'label'    => 'Neutral Responses',
                    'readonly' => true,
                    'value'    => $neutralCount ?? 0,
                    'class'    => 'form-control'
                ]) ?>
            </div>

            <!-- Negative Count -->
            <div class="col-md-4">
                <?= $this->Form->control('negative', [
                    'type'     => 'number',
                    'label'    => 'Negative Responses',
                    'readonly' => true,
                    'value'    => $negativeCount ?? 0,
                    'class'    => 'form-control'
                ]) ?>
            </div>
        </div>

        <!-- Predict NPS Button Row -->
        <div class="row mb-4">
            <div class="col-md-4 offset-md-4">
                <button type="button" class="btn btn-success w-100" id="predict-nps-btn">Predict NPS</button>
            </div>
        </div>

        <!-- Display NPS Prediction Result -->
        <div class="row mb-4">
            <div class="col-md-4 offset-md-4">
                <input type="text" id="nps-result" class="form-control" readonly />
            </div>
        </div>

        <!-- End Form -->
        <?= $this->Form->end() ?>
</div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const branchField = document.getElementById('branch');
    const dateField = document.getElementById('date');
    const form = document.getElementById('nps-form');
    const predictButton = document.getElementById('predict-nps-btn');
    const resultField = document.getElementById('nps-result');

    function autoSubmit() {
        if (branchField.value && dateField.value) {
            form.submit();
        }
    }

    branchField.addEventListener('change', autoSubmit);
    dateField.addEventListener('change', autoSubmit);

    // Add event listener to the "Predict NPS" button
    predictButton.addEventListener('click', async function () {
        // Get the values from the input fields
        const positiveCount = document.querySelector('input[name="positive"]').value;
        const neutralCount = document.querySelector('input[name="neutral"]').value;
        const negativeCount = document.querySelector('input[name="negative"]').value;

        // Ensure the values are integers before sending the request
        if (positiveCount && neutralCount && negativeCount) {
            // Send the request to FastAPI
            const response = await fetch('http://localhost:8000/predict-nps', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    positive: parseInt(positiveCount),
                    neutral: parseInt(neutralCount),
                    negative: parseInt(negativeCount)
                })
            });

            // Check if the response was successful
            if (response.ok) {
                const data = await response.json();
                resultField.value = data.nps_result || 'Error: Could not fetch result';
            } else {
                resultField.value = 'Error: Failed to get prediction';
            }
        } else {
            resultField.value = 'Please load the counts first.';
        }
    });
});
</script>
</html>
