<?php
namespace App\Utility;

class HospitalNPS
{
    private $totalResponses;
    private $csatScore;

    public function __construct($totalResponses, $csatScore)
    {
        $this->totalResponses = (int) $totalResponses;
        $this->csatScore = (int) $csatScore;
    }

    public function calculateNps()
    {
        // Classify based on the single CSAT score (0-100)
        if ($this->csatScore >= 90) {
            $promoters = 1;
            $detractors = 0;
        } elseif ($this->csatScore >= 70) {
            $promoters = 0;
            $detractors = 0;
        } else {
            $promoters = 0;
            $detractors = 1;
        }

        // Check to avoid division by zero
        if ($this->totalResponses > 0) {
            $nps = (($promoters - $detractors) / $this->totalResponses) * 100;
        } else {
            $nps = 0; // If there are no responses, NPS is 0
        }

        return $nps;
    }

    public function endorseDecision()
    {
        $nps = $this->calculateNps();

        // Determine if the hospital can be endorsed
        if ($nps > 50) {
            return "Endorsed (NPS: " . number_format($nps, 2) . ")";
        } else {
            return "Not Endorsed (NPS: " . number_format($nps, 2) . ")";
        }
    }
}
