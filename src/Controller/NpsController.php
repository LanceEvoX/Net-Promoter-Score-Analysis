<?php
namespace App\Controller;
use Cake\Http\Client;

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

            // Create HTTP Client to make the request to FastAPI
            $http = new Client();

            // Define FastAPI URL (assuming it's running on localhost:8000)
            $url = 'http://localhost:8000/predict-nps';

            // Prepare data for FastAPI
            $data = [
                'total_responses' => $totalResponses,
                'csat_score' => $csatScore
            ];

            // Send POST request to FastAPI
            $response = $http->post($url, json_encode($data), [
                'headers' => ['Content-Type' => 'application/json']
            ]);

            // Check if the request was successful
            if ($response->isOk()) {
                // Get the result from FastAPI response
                $npsResult = $response->getJson()['nps_result'];
            } else {
                // Handle error if FastAPI is down or returns an error
                $npsResult = "Error connection";
            }
        }

        // Pass the result to the view
        $this->set(compact('npsResult'));
    }
}
