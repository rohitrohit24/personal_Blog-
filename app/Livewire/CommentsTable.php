<?php

namespace App\Livewire;

use App\Models\Comment;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Livewire\Attributes\On;

class CommentsTable extends DataTableComponent
{
    protected $model = Comment::class;

    #[On('executeDeleteComment')]
    public function destroyComment($id)
    {
        if ($id) {
            Comment::where('id', $id)->delete();
            $this->dispatch('close-modal', modalId: 'deleteCommentsModal');
            $this->dispatch('refreshDatatable');
        }
    }

    #[On('executeApproveComment')]
    public function approveComment($id)
    {
        if ($id) {
            Comment::where('id', $id)->update(['status' => 'approved']);
            $this->dispatch('refreshDatatable');
        }
    }

    #[On('executeRejectComment')]
    public function rejectComment($id)
    {
        if ($id) {
            Comment::where('id', $id)->update(['status' => 'spam']);
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

            Column::make("User", "name")
                ->format(function ($value, $row) {
                    $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($row->name) . '&background=4f46e5&color=fff&bold=true&size=128';
                    return '
                        <div class="d-flex align-items-center gap-3">
                            <img src="' . $avatar . '" class="rounded-circle shadow-sm border border-2 border-primary-subtle flex-shrink-0" width="42" height="42" alt="' . e($row->name) . '" style="object-fit: cover;">
                            <div>
                                <div class="fw-bold text-dark text-capitalize mb-0" style="font-size: 0.95rem; line-height: 1.2;">' . e($row->name) . '</div>
                                <small class="text-muted d-block" style="font-size: 0.8rem;">' . e($row->email) . '</small>
                            </div>
                        </div>
                    ';
                })
                ->html()
                ->sortable()
                ->searchable(),

            Column::make("Comment Details", "comment_body")
                ->format(function ($value, $row) {
                    $postTitle = e($row->post->title ?? 'General Post');
                    $commentText = e(\Illuminate\Support\Str::limit($row->comment_body, 85));
                    return '
                        <div>
                            <div class="mb-1">
                                <span class="badge bg-light text-primary border border-primary-subtle px-2 py-1 fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-newspaper me-1"></i>' . $postTitle . '
                                </span>
                            </div>
                            <div class="text-secondary small text-wrap" style="max-width: 280px; line-height: 1.35; font-style: italic;">
                                "' . $commentText . '"
                            </div>
                        </div>
                    ';
                })
                ->html()
                ->searchable(),

            Column::make("Status", "status")
                ->format(function ($value) {
                    if ($value === 'approved') {
                        return '<span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2 fw-semibold"><i class="fa-solid fa-circle-check me-1"></i> Approved</span>';
                    } elseif ($value === 'spam') {
                        return '<span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fw-semibold"><i class="fa-solid fa-circle-xmark me-1"></i> Rejected</span>';
                    } else {
                        return '<span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 fw-semibold"><i class="fa-solid fa-clock me-1"></i> Pending</span>';
                    }
                })
                ->html()
                ->sortable(),

            Column::make("Created At", "created_at")
                ->format(fn($value) => '<span class="text-muted fw-medium" style="font-size: 0.85rem;">' . $value->format('d M, Y') . '</span>')
                ->html()
                ->sortable(),

            Column::make('Actions', 'id')
                ->format(function ($value, $row) {
                    $rowData = e(json_encode([
                        'id' => $row->id,
                        'post_id' => $row->post_id,
                        'name' => $row->name,
                        'email' => $row->email,
                        'comment_body' => $row->comment_body,
                        'status' => $row->status
                    ]));

                    $isApproved = $row->status === 'approved';
                    $isRejected = $row->status === 'spam';

                    $approveBtn = $isApproved
                        ? '<button class="btn btn-sm btn-success px-2 py-1 opacity-75" disabled title="Already Approved"><i class="fa-solid fa-check me-1"></i>Approved</button>'
                        : '<button class="btn btn-sm btn-outline-success px-2 py-1 approve-action-btn" data-id="' . $row->id . '" title="Approve Comment"><i class="fa-solid fa-check me-1"></i>Approve</button>';

                    $rejectBtn = $isRejected
                        ? '<button class="btn btn-sm btn-danger px-2 py-1 opacity-75" disabled title="Already Rejected"><i class="fa-solid fa-xmark me-1"></i>Rejected</button>'
                        : '<button class="btn btn-sm btn-outline-danger px-2 py-1 reject-action-btn" data-id="' . $row->id . '" title="Reject Comment"><i class="fa-solid fa-xmark me-1"></i>Reject</button>';

                    return '
                        <div class="d-flex align-items-center gap-1 justify-content-center">
                            ' . $approveBtn . '
                            ' . $rejectBtn . '
                            <button type="button" class="btn btn-sm btn-outline-primary edit-action-btn px-2 py-1" data-bs-toggle="modal" data-bs-target="#editCommentsModal" data-row="' . $rowData . '" title="Edit Comment">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary delete-action-btn px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleteCommentsModal" data-row="' . $rowData . '" title="Delete Comment">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->html(),
        ];
    }
}
