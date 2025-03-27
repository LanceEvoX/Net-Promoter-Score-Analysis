<?php
namespace App\Controller;
use App\Utility\HospitalNPS;

class NpsController extends AppController
{
    public function index()
    {
        // Load the Responses and Branches models
        $this->loadModel('Responses');
        $this->loadModel('Branches');
    
        // Fetch branches for the dropdown
        $branches = $this->Branches->find('list')->toArray();
    
        // Fetch unique months from the created date for the dropdown
        $months = $this->Responses->find()
            ->select(['month' => 'MONTH(created)'])
            ->distinct(['month'])
            ->order(['month' => 'ASC'])
            ->toArray();
    
        // Fetch unique years from the created date for the dropdown
        $years = $this->Responses->find()
            ->select(['year' => 'YEAR(created)'])
            ->distinct(['year'])
            ->order(['year' => 'ASC'])
            ->toArray();
    
        // Initialize totalResponses to null
        $totalResponses = null;
    
        // Pass data to the view
        $this->set(compact('branches', 'months', 'years', 'totalResponses'));
    }
    public function getBranchMonthYearResponseTotals()
    {
        // Load the Responses and Branches models
        $this->loadModel('Responses');
        $this->loadModel('Branches');
    
        // Fetch branches for the dropdown
        $branches = $this->Branches->find('list')->toArray();
    
        // Fetch unique months from the created date for the dropdown
        $months = $this->Responses->find()
            ->select(['month' => 'MONTH(created)'])
            ->distinct(['month'])
            ->order(['month' => 'ASC'])
            ->toArray();
    
        // Fetch unique years from the created date for the dropdown
        $years = $this->Responses->find()
            ->select(['year' => 'YEAR(created)'])
            ->distinct(['year'])
            ->order(['year' => 'ASC'])
            ->toArray();
    
        // Initialize totalResponses to null
        $totalResponses = null;
    
        // Check if the form is submitted
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $selectedBranch = $data['branch'];
            $selectedMonth = $data['month'];
            $selectedYear = $data['year'];
    
            // Calculate total responses based on branch, month, and year
            $totalResponses = $this->Responses->find()
                ->where([
                    'branch_id' => $selectedBranch,
                    'MONTH(created)' => $selectedMonth,
                    'YEAR(created)' => $selectedYear
                ])
                ->count();
        }
    
        // Pass data to the view
        $this->set(compact('branches', 'months', 'years', 'totalResponses'));
    }

    public function npscalculate()
    {
        $npsResult = null;

        if ($this->request->is('post')) {
            $totalResponses = $this->request->getData('total_responses');
            $csatScore = $this->request->getData('csat_score');

            // Instantiate the HospitalNPS utility class
            $hospitalNps = new HospitalNPS($totalResponses, $csatScore);

            // Get the endorsement decision
            $npsResult = $hospitalNps->endorseDecision();
        }

        // Pass the result to the view
        $this->set(compact('npsResult'));
    }
}
