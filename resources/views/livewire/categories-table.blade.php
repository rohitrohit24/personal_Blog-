<div>
    <!-- Table Header Toolbar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Search -->
        <div class="position-relative" style="width: 300px;">
            <i class="fa-solid fa-search position-absolute text-muted" style="top: 50%; left: 1rem; transform: translateY(-50%);"></i>
            <input type="text" wire:model.live="search" class="form-control rounded-pill ps-5 bg-light border-0" placeholder="Search categories...">
        </div>
        
        <!-- Filters (Optional) -->
        <div>
            <select wire:model.live="sortBy" class="form-select rounded-pill border-0 bg-light text-muted fw-medium" style="width: auto;">
                <option value="newest">Sort by Newest</option>
                <option value="oldest">Sort by Oldest</option>
                <option value="a-z">Alphabetical (A-Z)</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive table-container border-0 shadow-sm">
        <table class="table table-hover align-middle mb-0">
            <thead class="text-muted">
                <tr>
                    <th class="py-3 px-4 border-0 fw-semibold" style="width: 50px;">#</th>
                    <th class="py-3 px-4 border-0 fw-semibold">Name</th>
                    <th class="py-3 px-4 border-0 fw-semibold">Slug</th>
                    <th class="py-3 px-4 border-0 fw-semibold text-center">Posts</th>
                    <th class="py-3 px-4 border-0 fw-semibold text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Uncomment and use this loop when backend is ready --}}
                {{-- @forelse ($categories as $index => $category) --}}
                
                <!-- Dummy Row 1 -->
                <tr>
                    <td class="py-3 px-4 text-muted">1</td>
                    <td class="py-3 px-4">
                        <div class="fw-bold text-dark">Web Development</div>
                        <div class="small text-muted mt-1">Learn HTML, CSS, and JS</div>
                    </td>
                    <td class="py-3 px-4 text-muted">web-development</td>
                    <td class="py-3 px-4 text-center">
                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2 fw-medium">12</span>
                    </td>
                    <td class="py-3 px-4 text-end">
                        <button class="btn btn-sm btn-light rounded-circle text-primary me-2" style="width: 35px; height: 35px;" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-light rounded-circle text-danger" style="width: 35px; height: 35px;" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                
                <!-- Dummy Row 2 -->
                <tr>
                    <td class="py-3 px-4 text-muted">2</td>
                    <td class="py-3 px-4">
                        <div class="fw-bold text-dark">Laravel Tutorial</div>
                        <div class="small text-muted mt-1">PHP framework guide</div>
                    </td>
                    <td class="py-3 px-4 text-muted">laravel-tutorial</td>
                    <td class="py-3 px-4 text-center">
                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2 fw-medium">5</span>
                    </td>
                    <td class="py-3 px-4 text-end">
                        <button class="btn btn-sm btn-light rounded-circle text-primary me-2" style="width: 35px; height: 35px;" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-light rounded-circle text-danger" style="width: 35px; height: 35px;" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <!-- Empty State Example (Commented out for later) -->
                {{-- @empty --}}
                {{-- 
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="mb-3">
                            <i class="fa-solid fa-folder-open text-muted opacity-50" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="fw-bold text-dark">No Categories Found</h6>
                        <p class="text-muted small mb-0">Get started by creating a new category.</p>
                    </td>
                </tr> 
                --}}
                {{-- @endforelse --}}
            </tbody>
        </table>
    </div>

    <!-- Pagination Example -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <span class="text-muted small">Showing 1 to 2 of 2 entries</span>
        <nav>
            <ul class="pagination pagination-sm mb-0 shadow-sm">
                <li class="page-item disabled"><a class="page-link rounded-start-pill px-3 border-0" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link border-0" href="#">1</a></li>
                <li class="page-item"><a class="page-link rounded-end-pill px-3 border-0" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
