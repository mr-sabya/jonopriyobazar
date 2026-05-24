<?php

namespace App\Livewire\Backend\Faq;

use App\Models\Faq;
use Livewire\Component;
use Livewire\WithPagination;

class Manage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Properties for Form
    public $question, $answer, $faq_id;
    public $search = '';
    public $isEditMode = false;

    protected $rules = [
        'question' => 'required|string',
        'answer' => 'required|string',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->question = '';
        $this->answer = '';
        $this->faq_id = null;
        $this->isEditMode = false;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        Faq::updateOrCreate(
            ['id' => $this->faq_id],
            [
                'question' => $this->question,
                'answer' => $this->answer,
            ]
        );

        session()->flash('success', $this->isEditMode ? 'FAQ updated successfully.' : 'FAQ added successfully.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $this->faq_id = $faq->id;
        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        Faq::findOrFail($id)->delete();
        session()->flash('success', 'FAQ deleted successfully.');
        $this->resetFields();
    }

    public function render()
    {
        $faqs = Faq::where('question', 'like', '%' . $this->search . '%')
            ->orWhere('answer', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.backend.faq.manage', [
            'faqs' => $faqs
        ]);
    }
}