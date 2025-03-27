<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Total Responses</title>
    <!-- Add Bootstrap CDN for easier styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<style>
        body {
            font-size: 1.5rem; /* Base font size increased */
        }
        label {
            font-size: 1.8rem; /* Larger labels */
        }
        .form-control, .form-select {
            font-size: 1.3rem; /* Enlarge input and dropdown text */
            padding: 1rem; /* Increase padding for better spacing */
        }
        .btn-primary {
            font-size: 1.4rem; /* Enlarge button text */
            padding: 1rem 2rem; /* Adjust button padding */
        }
    </style>

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4">Total Responses of Selected Hospital/Clinic Branch</h2>

        <?= $this->Form->create(null, ['url' => ['action' => 'getBranchMonthYearResponseTotals'], 'class' => 'form']) ?>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="branch" class="form-label">Select Branch (Hospital)</label>
                <?= $this->Form->control('branch', [
                    'type' => 'select',
                    'options' => $branches,
                    'label' => false, // Label already added above
                    'empty' => 'Choose a Branch',
                    'class' => 'form-select',
                    'required' => true
                ]) ?>
            </div>
            <div class="col-md-4">
                <label for="month" class="form-label">Select Month</label>
                <?php
                $months = [
                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 
                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                ];
                ?>
                <?= $this->Form->control('month', [
                    'type' => 'select',
                    'options' => $months,
                    'label' => false,
                    'empty' => 'Choose a Month',
                    'class' => 'form-select',
                    'required' => true
                ]) ?>
            </div>
            <div class="col-md-4">
                <label for="year" class="form-label">Select Year</label>
                <?= $this->Form->control('year', [
                    'type' => 'select',
                    'options' => array_combine(array_column($years, 'year'), array_column($years, 'year')),
                    'label' => false,
                    'empty' => 'Choose a Year',
                    'class' => 'form-select',
                    'required' => true
                ]) ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="total_responses" class="form-label">Total Responses</label>
                <?= $this->Form->control('total_responses', [
                    'type' => 'text',
                    'value' => isset($totalResponses) ? $totalResponses : '0',
                    'readonly' => true,
                    'class' => 'form-control bg-light text-dark',
                    'label' => false
                ]) ?>
            </div>
        </div>

        <div class="text-center">
            <?= $this->Form->button('Calculate Total Responses', ['class' => 'btn btn-primary']) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Optional: Add Bootstrap JS for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
