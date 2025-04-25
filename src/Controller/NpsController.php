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
        $this->loadModel('Sentiments');
        $npsResult = null;
    
        // Count each sentiment
        $positiveCount = $this->Sentiments->find()->where(['sentiment' => 'Positive'])->count();
        $neutralCount = $this->Sentiments->find()->where(['sentiment' => 'Neutral'])->count();
        $negativeCount = $this->Sentiments->find()->where(['sentiment' => 'Negative'])->count();

    
        if ($this->request->is('post')) {
            $data = [
                'positive' => $positiveCount,
                'neutral' => $neutralCount,
                'negative' => $negativeCount
            ];
    
            $http = new Client();
            $url = 'http://localhost:8000/predict-nps';
    
            $response = $http->post($url, json_encode($data), [
                'headers' => ['Content-Type' => 'application/json']
            ]);
    
            if ($response->isOk()) {
                $npsResult = $response->getJson()['nps_result'];
            } else {
                $npsResult = "Error connection";
            }
        }
    
        $this->set(compact('npsResult', 'positiveCount', 'neutralCount', 'negativeCount'));
    }     
}
