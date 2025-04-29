<?php
namespace App\Controller;

use Cake\Http\Client;
use Cake\ORM\TableRegistry;

class NpsController extends AppController
{
    // src/Controller/NpsController.php
    public function index()
    {
        $this->loadModel('Sentiments');

        // Fetch branches for dropdown
        $branches = $this->Sentiments
            ->find('list', [
                'keyField'   => 'branch',
                'valueField' => 'branch'
            ])
            ->where(['branch IS NOT' => null])
            ->distinct(['branch'])
            ->order(['branch' => 'ASC'])
            ->toArray();

        // Initialize
        $selectedBranch = '';
        $selectedDate   = '';
        $positiveCount  = 0;
        $neutralCount   = 0;
        $negativeCount  = 0;

        // Only if POST
        if ($this->request->is('post')) {
            $selectedBranch = $this->request->getData('branch');
            $selectedDate   = $this->request->getData('date');

            if (!empty($selectedBranch) && !empty($selectedDate)) {
                list($year, $month) = explode('-', $selectedDate);

                // Filter base condition
                $baseConditions = [
                    'branch'               => $selectedBranch,
                    'YEAR(analysis_date)'  => $year,
                    'MONTH(analysis_date)' => $month,
                ];

                // Now for each sentiment
                $positiveCount = $this->Sentiments->find()
                    ->where(array_merge($baseConditions, ['sentiment' => 'Positive']))
                    ->count();

                $neutralCount = $this->Sentiments->find()
                    ->where(array_merge($baseConditions, ['sentiment' => 'Neutral']))
                    ->count();

                $negativeCount = $this->Sentiments->find()
                    ->where(array_merge($baseConditions, ['sentiment' => 'Negative']))
                    ->count();
            }
        }

        $this->set(compact(
            'branches',
            'selectedBranch',
            'selectedDate',
            'positiveCount',
            'neutralCount',
            'negativeCount'
        ));
    }
}
