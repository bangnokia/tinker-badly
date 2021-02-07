<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class Tinker extends Component
{
    public $showAddProject = false;

    public $showAddRemoteProject = true;

    public $projectPath = '';

    /**
     * @var Project
     */
    public $project;

    protected $listeners = ['changeDirectory', 'toggleAddProject'];

    public function mount()
    {
        $this->project = Project::current();
    }

    public function updatingProjectPath($value)
    {
        $this->projectName = basename($value);
    }

    public function changeDirectory($directory)
    {
        Project::query()
            ->updateOrCreate(['path' => $directory], ['name' => basename($directory)])
            ->setAsActive();

        $this->project = Project::current();

        $this->showAddProject = false;
        $this->emit('projectChanged');
    }

    public function toggleAddProject()
    {
        $this->showAddProject = !$this->showAddProject;
        if ($this->showAddProject === true) {
            $this->showAddRemoteProject = false;
        }
    }

    public function toggleAddRemoteProject()
    {
        $this->showAddRemoteProject = !$this->showAddRemoteProject;
        if ($this->showAddRemoteProject === true) {
            $this->showAddProject = false;
        }
    }

    public function closePopup()
    {
        $this->showAddProject = false;
        $this->showAddRemoteProject = false;
    }

    public function render()
    {
        return view('livewire.tinker');
    }
}
