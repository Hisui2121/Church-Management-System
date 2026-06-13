{{-- Check-in Widget (AJAX-enabled) --}}
@if(isset($activeSession) && $activeSession && !$hasCheckedInSession)
<div class="check-in-widget" id="checkin-widget">
    <div class="check-in-content">
        <div class="check-in-icon">
            <i class="bi bi-clock-check"></i>
        </div>
        <div class="check-in-info">
            <h3 class="check-in-title">Service Check-in</h3>
            <p class="check-in-subtitle">{{ $activeSession->service_title ?? 'Service is currently active.' }} Check in to mark your attendance.</p>
        </div>

        <div style="margin-left: auto;">
            <button id="checkin-btn" class="btn btn-check-in" aria-live="polite">
                <span id="checkin-btn-icon"><i class="bi bi-check-circle"></i></span>
                <span id="checkin-btn-text">Check In Now</span>
            </button>
        </div>
    </div>
</div>

@elseif(isset($activeSession) && $activeSession && $hasCheckedInSession)
<div class="check-in-widget checked" id="checkin-widget-checked">
    <div class="check-in-content">
        <div class="check-in-icon success">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="check-in-info">
            <h3 class="check-in-title">Already Checked In</h3>
            <p class="check-in-subtitle">You are already checked in for today.</p>
        </div>
    </div>
</div>
@endif

<style>
    .check-in-widget {
        background: linear-gradient(135deg, var(--primary-light) 0%, rgba(79, 70, 229, 0.05) 100%);
        border: 1px solid var(--primary-light);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .check-in-widget.checked {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
        border-color: rgba(16, 185, 129, 0.2);
    }

    .check-in-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .check-in-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        background: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 28px;
        flex-shrink: 0;
    }

    .check-in-icon.success {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }

    .check-in-info {
        flex: 1;
    }

    .check-in-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 4px 0;
    }

    .check-in-subtitle {
        font-size: 13px;
        color: var(--text-muted);
        margin: 0;
    }

    .btn-check-in {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-check-in:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    @media (max-width: 768px) {
        .check-in-content {
            flex-direction: column;
            text-align: center;
        }

        .btn-check-in {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('checkin-btn');
    if (!btn) return;

    const originalText = document.getElementById('checkin-btn-text');
    const iconSpan = document.getElementById('checkin-btn-icon');
    const url = "{{ route('member.check_in') }}";

    btn.addEventListener('click', async function (e) {
        e.preventDefault();
        btn.disabled = true;
        iconSpan.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        originalText.textContent = 'Checking in...';

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await res.json().catch(() => ({}));

            if (res.ok && data.success) {
                const widget = document.getElementById('checkin-widget');
                if (widget) {
                    widget.innerHTML = `
                        <div class="check-in-content">
                            <div class="check-in-icon success"><i class="bi bi-check-circle-fill"></i></div>
                            <div class="check-in-info">
                                <h3 class="check-in-title">Checked In</h3>
                                <p class="check-in-subtitle">Thanks — your attendance has been recorded.</p>
                            </div>
                        </div>`;
                }
            } else {
                const msg = data.message || 'Check-in failed. Please try again.';
                btn.disabled = false;
                iconSpan.innerHTML = '<i class="bi bi-check-circle"></i>';
                originalText.textContent = 'Check In Now';
                alert(msg);
            }
        } catch (err) {
            btn.disabled = false;
            iconSpan.innerHTML = '<i class="bi bi-check-circle"></i>';
            originalText.textContent = 'Check In Now';
            alert('Network error. Please try again.');
        }
    });
});
</script>
