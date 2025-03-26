<h1>Net Promoter Score Calculation</h1>

<?= $this->Form->create(null, ['url' => ['action' => 'calculate']]) ?>
    <fieldset>
        <legend>Enter Responses and CSAT Score</legend>
        <?= $this->Form->control('total_responses', ['label' => 'Total Responses', 'type' => 'number', 'required' => true]) ?>
        <?= $this->Form->control('csat_score', ['label' => 'CSAT Score (0-100)', 'type' => 'number', 'required' => true]) ?>
    </fieldset>
    <?= $this->Form->button('Calculate NPS') ?>
<?= $this->Form->end() ?>

<?php if (isset($npsResult)): ?>
    <h3>Result: <?= h($npsResult) ?></h3>
<?php endif; ?>
