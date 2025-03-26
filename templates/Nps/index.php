<h1>Net Promoter Score Calculation</h1>

<?= $this->Form->create(null, ['url' => ['action' => 'calculate']]) ?>
    <fieldset>
    <?= $this->Form->control('hospital', [
        'type' => 'select',
        'options' => $branches,
        'label' => 'Select a Hospital'
    ]) ?>
    <?= $this->Form->control('response', [
        'type' => 'select',
        'options' => $monthOptions,
        'label' => 'Select a Month'
    ]) ?>
        <legend>Enter Responses and CSAT Score</legend>
        
        <?php foreach ($branchResponseTotals as $branchId => $totalResponses): ?>
            <div>
                <label>Branch (Hospital) ID: <?= h($branchId) ?></label>
                <?= $this->Form->control('total_responses_' . $branchId, [
                    'type' => 'text',
                    'value' => $totalResponses,
                    'readonly' => true, // Make the textbox uneditable
                    'label' => false // Don't show the label for the textbox
                ]) ?>
            </div>
        <?php endforeach; ?>

        <?= $this->Form->control('csat_score', ['label' => 'CSAT Score (0-100)', 'type' => 'number', 'required' => true]) ?>
    </fieldset>
    <?= $this->Form->button('Calculate NPS') ?>
<?= $this->Form->end() ?>








