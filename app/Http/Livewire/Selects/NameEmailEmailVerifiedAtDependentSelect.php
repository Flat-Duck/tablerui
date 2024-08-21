<?php

namespace App\Http\Livewire\Selects;

use App\Models\User;
use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NameEmailEmailVerifiedAtDependentSelect extends Component
{
    use AuthorizesRequests;

    public $allNames;
    public $allEmails;
    public $allEmailVerifiedAts;

    public $selectedName;
    public $selectedEmail;
    public $selectedEmailVerifiedAt;

    protected $rules = [
        'selectedName' => ['required', 'max:255', 'string'],
        'selectedEmail' => ['required', 'unique:users,email', 'email'],
        'selectedEmailVerifiedAt' => ['nullable', 'date'],
    ];

    public function mount($user): void
    {
        $this->clearData();
        $this->fillAllNames();

        if (is_null($user)) {
            return;
        }

        $user = User::findOrFail($user);

        $this->selectedName = $user->name;

        $this->fillAllEmails();
        $this->selectedEmail = $user->email;

        $this->fillAllEmailVerifiedAts();
        $this->selectedEmailVerifiedAt = $user->email_verified_at;
    }

    public function updatedSelectedName(): void
    {
        $this->selectedEmail = null;
        $this->fillAllEmails();
    }

    public function updatedSelectedEmail(): void
    {
        $this->selectedEmailVerifiedAt = null;
        $this->fillAllEmailVerifiedAts();
    }

    public function fillAllNames(): void
    {
        $this->allNames = [];
    }

    public function fillAllEmails(): void
    {
        if (!$this->selectedName) {
            return;
        }

        $emails = [];

        if (!isset($emails[$this->selectedName])) {
            $this->selectedEmail = null;
            $this->allEmails = [];
            return;
        }

        $this->allEmails = $emails[$this->selectedName];
    }

    public function fillAllEmailVerifiedAts(): void
    {
        if (!$this->selectedEmail) {
            return;
        }

        $emailVerifiedAts = [];

        if (!isset($emailVerifiedAts[$this->selectedEmail])) {
            $this->selectedEmailVerifiedAt = null;
            $this->allEmailVerifiedAts = [];
            return;
        }

        $this->allEmailVerifiedAts = $emailVerifiedAts[$this->selectedEmail];
    }

    public function clearData(): void
    {
        $this->allNames = null;
        $this->allEmails = null;
        $this->allEmailVerifiedAts = null;

        $this->selectedName = null;
        $this->selectedEmail = null;
        $this->selectedEmailVerifiedAt = null;
    }

    public function render(): View
    {
        return view(
            'livewire.selects.name-email-email-verified-at-dependent-select'
        );
    }
}
