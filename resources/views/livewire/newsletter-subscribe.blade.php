<div class="newsletter-subscribe-wrapper {{ $variant === 'navbar' ? 'd-inline-flex align-items-center' : 'd-inline-block w-100' }}">
    {{-- 1. NAVBAR VARIANT --}}
    @if ($variant === 'navbar')
        @if ($isSubscribed)
            <span class="badge rounded-pill px-3 py-2 text-white d-inline-flex align-items-center gap-2 shadow-sm"
                style="background-color: #059669; font-size: 14px;">
                <i class="fa-solid fa-check"></i> Subscribed!
                <button type="button" wire:click="unsubscribe" class="btn btn-sm btn-light py-0 px-2 ms-2"
                    style="font-size: 11px; border-radius: 10px;">
                    <span wire:loading.remove wire:target="unsubscribe">Unsubscribe</span>
                    <span wire:loading wire:target="unsubscribe">Wait...</span>
                </button>
            </span>
        @elseif ($isOpen)
            <div class="d-inline-block position-relative w-100" style="max-width: 320px;">
                <form wire:submit="subscribe"
                    class="d-flex align-items-center gap-1 bg-white p-1 rounded-pill shadow w-100">
                    <input type="email" wire:model="email"
                        class="form-control form-control-sm border-0 rounded-pill px-3 py-1 text-dark flex-grow-1"
                        placeholder="Enter email..." autofocus required style="font-size: 14px; min-width: 0;">
                    <button type="submit"
                        class="btn btn-sm text-white rounded-pill px-3 py-1 fw-semibold flex-shrink-0"
                        style="background-color: var(--main-colour); font-size: 13px;" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="subscribe">Join</span>
                        <span wire:loading wire:target="subscribe" class="spinner-border spinner-border-sm"
                            role="status"></span>
                    </button>
                    <button type="button" wire:click="toggleOpen"
                        class="btn btn-sm btn-link text-muted p-1 me-1 text-decoration-none flex-shrink-0"
                        title="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </form>
                @error('email')
                    <div class="position-absolute start-0 top-100 mt-1 bg-danger text-white rounded px-2 py-1 small shadow-sm z-3"
                        style="font-size: 12px;">{{ $message }}</div>
                @enderror
            </div>
        @else
            <a href="javascript:void(0)" wire:click="toggleOpen"
                class="nav-link custom-nav-link subscribe-link text-decoration-none d-inline-flex align-items-center gap-1">Subscribe</a>
        @endif

    {{-- 2. HERO / BUTTON VARIANT --}}
    @elseif ($variant === 'hero' || $variant === 'button')
        @if ($statusMessage)
            <div class="alert alert-{{ $messageType === 'error' ? 'danger' : ($messageType === 'info' ? 'info' : 'success') }} py-1 px-3 small rounded-pill mb-2 shadow-sm d-inline-block">
                {{ $statusMessage }}
            </div>
        @endif

        @if ($isSubscribed)
            <div class="d-inline-flex align-items-center gap-2 p-2 px-3 rounded-pill bg-white text-dark shadow-sm mb-2">
                <i class="fa-solid fa-circle-check text-success fs-5"></i>
                <span class="fw-semibold small">Subscribed!</span>
                <button type="button" wire:click="unsubscribe"
                    class="btn btn-danger btn-sm rounded-pill px-3 ms-2 py-1" style="font-size: 12px;">
                    <span wire:loading.remove wire:target="unsubscribe">Unsubscribe</span>
                    <span wire:loading wire:target="unsubscribe">Wait...</span>
                </button>
            </div>
        @elseif ($isOpen)
            <div class="d-inline-block text-start mb-2 w-100" style="max-width: 440px;">
                <form wire:submit="subscribe"
                    class="d-flex align-items-center gap-2 p-1 rounded-pill bg-white shadow-lg border w-100">
                    <input type="email" wire:model="email"
                        class="form-control border-0 rounded-pill px-3 py-2 text-dark flex-grow-1"
                        placeholder="Enter your email address" autofocus required
                        style="font-size: 15px; min-width: 0;">
                    <button type="submit" class="custom-btn btn-solid px-3 px-sm-4 py-2 border-0 flex-shrink-0"
                        style="font-size: 15px; background-color: var(--main-colour); color: var(--second-colour) !important;"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="subscribe">Subscribe</span>
                        <span wire:loading wire:target="subscribe" class="spinner-border spinner-border-sm"
                            role="status"></span>
                    </button>
                    <button type="button" wire:click="toggleOpen"
                        class="btn btn-link text-muted p-2 me-1 text-decoration-none flex-shrink-0"><i
                            class="fa-solid fa-xmark"></i></button>
                </form>
                @error('email')
                    <div class="text-danger small mt-1 fw-medium px-2">{{ $message }}</div>
                @enderror
            </div>
        @else
            <button type="button" wire:click="toggleOpen"
                class="custom-btn mb-2 btn-outline d-inline-flex align-items-center gap-2"><span>Subscribe</span></button>
        @endif

    {{-- 3. FOOTER VARIANT --}}
    @elseif ($variant === 'footer')
        @if ($statusMessage)
            <div class="alert alert-{{ $messageType === 'error' ? 'danger' : ($messageType === 'info' ? 'info' : 'success') }} py-2 px-3 small rounded-4 mb-2">
                {{ $statusMessage }}
            </div>
        @endif

        @if ($isSubscribed)
            <div
                class="alert alert-success py-2 px-3 small rounded-4 mb-0 d-flex flex-column gap-2 text-dark bg-white border-0 shadow-sm">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-check text-success fs-5"></i>
                    <span class="fw-bold">Subscribed!</span>
                </div>
                <button type="button" wire:click="unsubscribe" class="btn btn-sm btn-outline-danger w-100 rounded-pill mt-1">
                    <span wire:loading.remove wire:target="unsubscribe">Unsubscribe</span>
                    <span wire:loading wire:target="unsubscribe">Wait...</span>
                </button>
            </div>
        @else
            <form wire:submit="subscribe">
                <div class="mb-2">
                    <input type="email" wire:model="email" class="form-control rounded-5 px-3 py-2 text-dark bg-white"
                        placeholder="Enter your email address" required>
                    @error('email')
                        <p class="text-warning small mt-1 mb-0">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="custom-btn btn-outline w-100 d-flex align-items-center justify-content-center gap-2"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="subscribe">Subscribe Now</span>
                    <span wire:loading wire:target="subscribe"><span class="spinner-border spinner-border-sm"
                            role="status"></span> Subscribing...</span>
                </button>
            </form>
        @endif

    {{-- 4. CONTACT VARIANT --}}
    @elseif ($variant === 'contact')
        @if ($statusMessage)
            <div class="alert alert-{{ $messageType === 'error' ? 'danger' : ($messageType === 'info' ? 'info' : 'success') }} p-3 rounded-4 mb-3">
                {{ $statusMessage }}
            </div>
        @endif

        @if ($isSubscribed)
            <div
                class="alert alert-success p-3 rounded-4 mb-0 d-flex flex-column gap-2 shadow-sm text-dark bg-white border-0">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-circle-check fs-2 text-success"></i>
                    <div>
                        <h6 class="mb-0 fw-bold text-success">Subscribed to Newsletter</h6>
                    </div>
                </div>
                <button type="button" wire:click="unsubscribe" class="btn btn-outline-danger btn-sm mt-2 rounded-3 w-100">
                    <span wire:loading.remove wire:target="unsubscribe">Unsubscribe</span>
                    <span wire:loading wire:target="unsubscribe">Wait...</span>
                </button>
            </div>
        @else
            <form wire:submit="subscribe">
                <div class="mb-3">
                    <input type="email" wire:model="email" class="form-control py-3 px-4 rounded-4"
                        placeholder="Enter your email address" required>
                    @error('email')
                        <div class="text-danger small mt-1 fw-medium">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" wire:model="consent"
                        id="livewireConsent_{{ $this->getId() }}" required>
                    <label class="form-check-label text-muted" for="livewireConsent_{{ $this->getId() }}">Yes, I want
                        to subscribe to your newsletter.</label>
                </div>
                <button type="submit"
                    class="btn main-colour w-100 text-uppercase fw-semibold py-3 rounded-4 d-flex align-items-center justify-content-center gap-2 shadow-sm"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="subscribe">Subscribe</span>
                    <span wire:loading wire:target="subscribe"><span class="spinner-border spinner-border-sm"
                            role="status"></span> Subscribing...</span>
                </button>
            </form>
        @endif

    {{-- 5. DEFAULT / BOX VARIANT --}}
    @else
        @if ($statusMessage)
            <div class="alert alert-{{ $messageType === 'error' ? 'danger' : ($messageType === 'info' ? 'info' : 'success') }} py-2 px-3 small rounded-3 mb-3">
                {{ $statusMessage }}
            </div>
        @endif

        @if ($isSubscribed)
            <div class="alert alert-success d-flex flex-column gap-3 rounded-3 py-3 px-3 mb-0 shadow-sm border-0"
                role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-check fs-4 text-success"></i>
                    <div>
                        <strong class="d-block text-success">Subscribed!</strong>
                        <span class="small text-dark">You are on our mailing list.</span>
                    </div>
                </div>
                <button type="button" wire:click="unsubscribe" class="btn btn-danger btn-sm w-100 rounded-3">
                    <span wire:loading.remove wire:target="unsubscribe">Unsubscribe</span>
                    <span wire:loading wire:target="unsubscribe">Wait...</span>
                </button>
            </div>
        @else
            <form wire:submit="subscribe">
                <div class="mb-3">
                    <input type="email" wire:model="email" class="form-control"
                        placeholder="Enter your email address" required>
                    @error('email')
                        <div class="text-danger small mt-1 fw-medium">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit"
                    class="btn main-colour w-100 text-uppercase fw-semibold py-2 d-flex align-items-center justify-content-center gap-2"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="subscribe">Subscribe</span>
                    <span wire:loading wire:target="subscribe"><span class="spinner-border spinner-border-sm"
                            role="status"></span> Subscribing...</span>
                </button>
            </form>
        @endif
    @endif
</div>
