<?php

namespace App\Http\Livewire\Admin\Programs;

use App\Models\ConductedProgram;
use App\Models\district;
use Livewire\Component;
use Livewire\WithPagination;

class ConductedPrograms extends Component
{

    use WithPagination;

    public $program_id, $program_name, $district, $conducted_date, $start_time, $end_time, $other_details, $districts;
    public $isModalOpen = false;

    public function render()
    {
        $this->districts = district::orderBy('name')->get(); // Adjust 'name' if different
        $programs = ConductedProgram::latest()->paginate(10);
        return view('livewire.admin.programs.conducted-programs', ['programs' => $programs]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->program_id = null;
        $this->program_name = '';
        $this->district = '';
        $this->conducted_date = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->other_details = '';
    }
    public function store()
    {
        $this->validate([
            'program_name' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'conducted_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'other_details' => 'nullable|string|max:1000',

        ]);

        ConductedProgram::updateOrCreate(['id' => $this->program_id], [
            'program_name' => $this->program_name,
            'district' => $this->district,
            'conducted_date' => $this->conducted_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'other_details' => $this->other_details,
        ]);

        session()->flash('message', $this->program_id ? 'Program updated successfully.' : 'Program
      created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $program = ConductedProgram::findOrFail($id);
        $this->program_id = $id;
        $this->program_name = $program->program_name;
        $this->district = $program->district;
        $this->conducted_date = $program->conducted_date;
        $this->start_time = $program->start_time;
        $this->end_time = $program->end_time;
        $this->other_details = $program->other_details;

        $this->openModal();
    }

    public function delete($id)
    {
        ConductedProgram::find($id)->delete();
        session()->flash('message', 'Program deleted successfully.');
    }
}
