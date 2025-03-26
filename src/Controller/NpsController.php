<?php
namespace App\Controller;
use App\Utility\HospitalNPS;

class NpsController extends AppController
{
    public function index()
    {
        $this->loadModel('Branches');

        // Fetch all branch names
        $branches = $this->Branches->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->toArray();

        // Pass branches to the view
        $this->set(compact('branches'));
            
        $this->loadModel('Responses');

        // Fetch distinct months from the created column
        $months = $this->Responses->find()
            ->select(['month' => 'DATE_FORMAT(created, "%M")']) // Get month name
            ->distinct(['month']) // Ensure unique months
            ->order(['created' => 'ASC']) // Order by date
            ->toArray();
    
        // Prepare the months array for the dropdown
        $monthOptions = [];
        foreach ($months as $month) {
            $monthOptions[$month->month] = $month->month; // Set the month name as both value and label
        }
    
        // Pass the months to the view
        $this->set(compact('monthOptions'));

        $branchTotals = $this->Responses->find()
        ->select(['branch_id', 'total_responses' => 'COUNT(id)']) // Count total responses per branch
        ->group('branch_id') // Group by branch_id
        ->order(['branch_id' => 'ASC']) // Optional: Order by branch ID
        ->toArray();

    // Prepare the data for the view
    $branchResponseTotals = [];
    foreach ($branchTotals as $branchTotal) {
        $branchResponseTotals[$branchTotal->branch_id] = $branchTotal->total_responses;
    }

    // Pass the totals to the view
    $this->set(compact('branchResponseTotals'));


        if ($this->request->is('post')) {
            // Get input data from form
            $totalResponses = $this->request->getData('total_responses');
            $csatScore = $this->request->getData('csat_score');

            // Create a new instance of HospitalNPS class and calculate NPS
            $hospitalNPS = new \App\Utility\HospitalNPS($totalResponses, $csatScore);
            $result = $hospitalNPS->endorseDecision();

            // Pass the result to the view
            $this->set('result', $result);
        }
    }
    public function getBranchResponseTotals()
    {
        // Load the Responses model
        $this->loadModel('Responses');

        // Fetch total responses for each branch (hospital)
        $branchTotals = $this->Responses->find()
            ->select(['branch_id', 'total_responses' => 'COUNT(id)']) // Count total responses per branch
            ->group('branch_id') // Group by branch_id
            ->order(['branch_id' => 'ASC']) // Optional: Order by branch ID
            ->toArray();

        // Prepare the data for the view
        $branchResponseTotals = [];
        foreach ($branchTotals as $branchTotal) {
            $branchResponseTotals[$branchTotal->branch_id] = $branchTotal->total_responses;
        }

        // Pass the totals to the view
        $this->set(compact('branchResponseTotals'));
    }

}
