<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Net Promoter Score Analyzation</title>
    <!-- Add Bootstrap CDN for easier styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS to enlarge text -->
    <style>
        body {
            font-size: 1.5rem; /* Base font size increased */
        }
        label {
            font-size: 1.8rem; /* Larger labels */
        }
        .form-control {
            font-size: 1.6rem; /* Enlarge input text */
            padding: 1rem; /* Increase padding for better spacing */
        }
        .btn-primary {
            font-size: 1.6rem; /* Enlarge button text */
            padding: 1rem 2rem; /* Adjust button padding */
        }
        .result {
            font-size: 2rem;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-lg p-5">
        <h2 class="text-center mb-4">Net Promoter Score Analyzation</h2>

        <?= $this->Form->create(null, ['url' => ['action' => 'npscalculate'], 'class' => 'form']) ?>
        
        <fieldset>
            <legend class="text-center mb-4">Enter Responses and CSAT Score</legend>
            
            <div class="mb-4">
                <?= $this->Form->control('total_responses', [
                    'label' => 'Total Responses', 
                    'type' => 'number', 
                    'class' => 'form-control', 
                    'required' => true
                ]) ?>
            </div>
            
            <div class="mb-4">
                <?= $this->Form->control('csat_score', [
                    'label' => 'CSAT Score (0-100)', 
                    'type' => 'number', 
                    'class' => 'form-control', 
                    'required' => true
                ]) ?>
            </div>
        </fieldset>

        <div class="text-center">
            <?= $this->Form->button('Analyze NPS', ['class' => 'btn btn-primary']) ?>
        </div>

        <?= $this->Form->end() ?>

        <!-- Display result -->
        <?php if (isset($npsResult)): ?>
        <h3 class="text-center result mt-5">Result: <?= h($npsResult) ?></h3>
        <?php endif; ?>
    </div>
</div>

<!-- Optional: Add Bootstrap JS for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
