<?php

namespace App\Livewire;

use App\Models\Category;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Livewire\Attributes\On;

class CategoriesTable extends DataTableComponent
{
    protected $model = Category::class;

    #[On('executeDeleteCategory')]
    public function destroyCategory($id)
    {
        if ($id) {
            Category::where('id', $id)->delete();

            $this->dispatch('close-modal', modalId: 'deleteCategoryModal');

            $this->dispatch('refreshDatatable');
        }
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'desc')
            ->setTableAttributes([
                'class' => 'table table-hover align-middle admin-table mb-0 sticky-actions-table',
            ]);
    }

    public function refreshTable() {}

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            Column::make("Category Name", "name")
                ->sortable()
                ->searchable(),

            Column::make("Slug", "slug")
                ->sortable(),

            Column::make("Created At", "created_at")
                ->format(fn($value) => '<span class="text-muted" style="font-size: 0.9rem;">' . $value->format('d M, Y') . '</span>')
                ->html()
                ->sortable(),

            Column::make('Actions', 'id')
                ->format(fn($value, $row, $column) => view('components.table-actions', [
                    'id' => $row->id,
                    'editTarget' => 'editCategoryModal',
                    'deleteTarget' => 'deleteCategoryModal',
                    'row' => $row
                ]))
                ->html(),
        ];
    }
}
