<?php

namespace App\Livewire;

use App\Models\Tag;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Builder;

class TagsTable extends DataTableComponent
{
    protected $model = Tag::class;

    #[On('executeDeleteTag')]
    public function destroyTag($id)
    {
        if ($id) {
            Tag::where('id', $id)->delete();
            $this->dispatch('close-modal', modalId: 'deleteTagsModal');
            $this->dispatch('refreshDatatable');
        }
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'desc')
            ->setTableAttributes([
                'class' => 'table table-hover align-middle admin-table sticky-actions-table mb-0',
            ]);
    }

    public function builder(): Builder
    {
        return Tag::query()->withCount('posts');
    }

    public function refreshTable() {}

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            Column::make("Tag Name", "name")
                ->format(fn($value) => '
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fw-semibold fs-6">
                        <i class="fa-solid fa-tag me-1"></i>' . e($value) . '
                    </span>
                ')
                ->html()
                ->sortable()
                ->searchable(),

            Column::make("Slug", "slug")
                ->format(fn($value) => '<code class="text-secondary fw-semibold">/' . e($value) . '</code>')
                ->html()
                ->sortable()
                ->searchable(),

            Column::make("Tagged Posts", "id")
                ->format(fn($value, $row) => '
                    <span class="badge rounded-pill bg-dark text-warning border border-warning px-3 py-2 fw-medium">
                        <i class="fa-solid fa-file-lines me-1"></i>' . ($row->posts_count ?? 0) . ' Posts
                    </span>
                ')
                ->html(),

            Column::make("Created At", "created_at")
                ->format(fn($value) => '<span class="text-muted fw-medium" style="font-size: 0.85rem;">' . $value->format('d M, Y') . '</span>')
                ->html()
                ->sortable(),

            Column::make('Actions', 'id')
                ->format(fn($value, $row, $column) => view('components.table-actions', [
                    'id' => $row->id,
                    'editTarget' => 'editTagsModal',
                    'deleteTarget' => 'deleteTagsModal',
                    'row' => $row
                ]))
                ->html(),
        ];
    }
}
