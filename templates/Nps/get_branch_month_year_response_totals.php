<h1>Total Responses for Selected Branch, Month, and Year</h1>

<?= $this->Form->create(null, ['url' => ['action' => 'getBranchMonthYearResponseTotals']]) ?>
    <fieldset>
        <div>
            <?= $this->Form->control('branch', [
                'type' => 'select',
                'options' => $branches,
                'label' => 'Select Branch (Hospital)',
                'empty' => 'Choose a Branch',
                'required' => true
            ]) ?>
        </div>

        <div>
            <?php
            // Month names with corresponding numeric values
            $months = [
                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 
                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
            ];
            ?>
            <?= $this->Form->control('month', [
                'type' => 'select',
                'options' => $months, // Months 1-12
                'label' => 'Select Month',
                'empty' => 'Choose a Month',
                'required' => true
            ]) ?>
        </div>

        <div>
            <?= $this->Form->control('year', [
                'type' => 'select',
                'options' => array_combine(array_column($years, 'year'), array_column($years, 'year')), // Correct year values
                'label' => 'Select Year',
                'empty' => 'Choose a Year',
                'required' => true
            ]) ?>
        </div>

        <div>
            <?= $this->Form->control('total_responses', [
                'type' => 'text',
                'value' => isset($totalResponses) ? $totalResponses : '0', // Display calculated total
                'readonly' => true, // Make textbox uneditable
                'label' => 'Total Responses'
            ]) ?>
        </div>
    </fieldset>
    <?= $this->Form->button('Calculate Total Responses') ?>
<?= $this->Form->end() ?>
