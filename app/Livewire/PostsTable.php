<?php

namespace App\Livewire;

use App\Models\Post;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Builder;

class PostsTable extends DataTableComponent
{
    protected $model = Post::class;

    #[On('executeDeletePost')]
    public function destroyPost($id)
    {
        if ($id) {
            Post::where('id', $id)->delete();
            $this->dispatch('close-modal', modalId: 'deletePostsModal');
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

    public function builder(): Builder
    {
        return Post::query()->with('tags');
    }

    public function refreshTable() {}

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            Column::make("Title", "title")
                ->sortable()
                ->searchable(),

            Column::make("Category", "category.name")
                ->sortable(),

            Column::make("Tags", "id")
                ->format(function($value, $row) {
                    if ($row->tags->isEmpty()) {
                        return '<span class="text-muted small">No Tags</span>';
                    }
                    return $row->tags->map(fn($t) => '<span class="badge bg-secondary-subtle text-dark border me-1"><i class="fa-solid fa-tag me-1 text-primary"></i>' . e($t->name) . '</span>')->implode('');
                })
                ->html(),

            Column::make("Status", "status")
                ->format(fn($value) => '<span class="badge rounded-pill ' . ($value === 'published' ? 'bg-success' : 'bg-warning') . ' px-3 py-2 fw-medium">' . ucfirst($value) . '</span>')
                ->html()
                ->sortable(),
            Column::make("slug", "slug")
                ->sortable(),

            Column::make("image", "image")
                ->sortable()
                ->deselected(),

            Column::make("Content", "content")
                ->sortable()
                ->deselected(),


            Column::make("Created At", "created_at")
                ->format(fn($value) => '<span class="text-muted" style="font-size: 0.9rem;">' . $value->format('d M, Y') . '</span>')
                ->html()
                ->sortable(),

            Column::make('Actions', 'id')
                ->format(fn($value, $row, $column) => view('components.table-actions', [
                    'id' => $row->id,
                    'editTarget' => 'editPostsModal',
                    'deleteTarget' => 'deletePostsModal',
                    'showTarget' => 'showPostsModal',
                    'row' => [
                        'id' => $row->id,
                        'title' => $row->title,
                        'slug' => $row->slug,
                        'category' => $row->category_id,
                        'status' => $row->status,
                        'content' => $row->content,
                        'image' => $row->image,
                        'tag_ids' => $row->tags->pluck('id')->toArray(),
                        'tag_names' => $row->tags->pluck('name')->toArray(),
                    ]
                ]))
                ->html(),
        ];
    }
}
