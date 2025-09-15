<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningResource;
use Illuminate\Support\Facades\Auth;

class LearningResourceController extends Controller
{
    protected $view;
    protected $route;
    protected $learning_resource;

    public function __construct() {
        $this->view = 'pages.student.learning-resource.';
        $this->route = 'learning-resource.';
        $this->learning_resource = new LearningResource();
    }

    public function index() {
        $learning_resource_count = 0;
        $user = Auth::user();
        $learning_resources = $this->learning_resource->where('school_id', $user->school_id)->get();
        return view($this->view . 'index', compact('learning_resource_count', 'learning_resources'));
    }

    public function show($id) {
        $learning_resource = LearningResource::findOrFail($id);

        return view($this->view . 'show', [
            'learning_resource' => $learning_resource
        ]);
    }
}
