<?php

namespace App\Http\Controllers;

use App\Models\User;

class FreelancerController extends Controller
{
    public function show(User $freelancer)
    {
        abort_if(! $freelancer->isFreelancer(), 404);

        $freelancer->load('receivedReviews.reviewer');

        return view('freelancers.show', [
            'freelancer' => $freelancer,
            'averageRating' => $freelancer->averageRating(),
            'completedCommissions' => $freelancer->completedCommissionsCount(),
            'averageDuration' => $freelancer->averageCommissionDurationInDays(),
        ]);
    }
}
