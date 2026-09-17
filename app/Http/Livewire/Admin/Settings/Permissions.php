<?php

declare(strict_types=1);

namespace App\Http\Livewire\Admin\Settings;

use App\Http\Livewire\Base;
use App\Models\Roles\Permission;
use App\Models\Roles\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\WithPagination;

use function add_user_log;
use function flash;
use function view;

class Permissions extends Base
{
    use WithPagination;

    public $permissionId;
    public $name = '';
    public $label = '';
    public $module = '';
    public $selectedRoles = [];
    public $search = '';
    public $roleFilter = '';

    protected $paginationTheme = 'tailwind';

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('permissions', 'name')->ignore($this->permissionId)->whereNull('deleted_at'),
            ],
            'label' => 'required|string',
            'module' => 'nullable|string',
            'selectedRoles' => 'array',
        ];
    }

    protected array $messages = [
        'name.required' => 'Permission name is required.',
        'label.required' => 'Permission label is required.',
    ];

    public function mount(): void
    {
        Paginator::defaultView('vendor.pagination.tailwind');
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render(): View
    {
        $roles = Role::orderBy('label')->get();
        $permissions = $this->permissionQuery();

        return view('livewire.admin.settings.permissions', compact('roles', 'permissions'))
            ->layout('layouts.app');
    }

    public function permissionQuery()
    {
        $query = Permission::with('roles')->orderBy('module')->orderBy('label');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('label', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('module', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->whereHas('roles', fn($q) => $q->where('id', $this->roleFilter));
        }

        return $query->paginate(12);
    }

    /**
     * @throws ValidationException
     */
    public function savePermission(): void
    {
        $this->validate();

        $permission = Permission::updateOrCreate(
            ['id' => $this->permissionId],
            [
                'name' => strtolower(str_replace(' ', '_', $this->name)),
                'label' => $this->label,
                'module' => $this->module,
            ]
        );

        $permission->roles()->sync($this->selectedRoles ?: []);

        if ($this->permissionId) {
            flash('Permission updated')->success();
            add_user_log([
                'title' => 'updated permission ' . $permission->label,
                'link' => route('admin.settings'),
                'reference_id' => $permission->id,
                'section' => 'Permissions',
                'type' => 'Update',
            ]);
        } else {
            flash('Permission created')->success();
            add_user_log([
                'title' => 'created permission ' . $permission->label,
                'link' => route('admin.settings'),
                'reference_id' => $permission->id,
                'section' => 'Permissions',
                'type' => 'Create',
            ]);
        }

        $this->resetForm();
        $this->resetPage();
    }

    public function editPermission(string $permissionId): void
    {
        $permission = Permission::with('roles')->findOrFail($permissionId);

        $this->permissionId = $permission->id;
        $this->name = $permission->name;
        $this->label = $permission->label;
        $this->module = $permission->module;
        $this->selectedRoles = $permission->roles->pluck('id')->toArray();
    }

    public function deletePermission(string $permissionId): void
    {
        $permission = Permission::findOrFail($permissionId);
        $permission->roles()->detach();
        $permission->delete();

        flash('Permission removed')->success();

        add_user_log([
            'title' => 'deleted permission ' . $permission->label,
            'link' => route('admin.settings'),
            'reference_id' => $permission->id,
            'section' => 'Permissions',
            'type' => 'Delete',
        ]);

        $this->resetForm();
        $this->resetPage();
    }

    public function resetForm(): void
    {
        $this->permissionId = null;
        $this->name = '';
        $this->label = '';
        $this->module = '';
        $this->selectedRoles = [];
        $this->resetValidation();
    }
}
