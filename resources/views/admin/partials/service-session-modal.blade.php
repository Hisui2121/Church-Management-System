{{-- Service Session Modal Partial: centered modal with full-screen backdrop --}}
<div id="serviceSessionModal" class="modal" style="display: none;">
    <div class="modal-backdrop" onclick="closeServiceSessionModal()"></div>
    <div class="modal-content service-session-modal">
        <div class="modal-header">
            <h3>Start New Service Session</h3>
            <button type="button" class="modal-close" onclick="closeServiceSessionModal()">&times;</button>
        </div>

        <form id="serviceSessionForm" action="{{ route('admin.session.toggle') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label required">Service Date & Time</label>
                <input type="datetime-local" name="session_date" class="form-input" required>
                @error('session_date') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Pastor</label>
                <input type="text" name="pastor_name" class="form-input" placeholder="Enter pastor name">
                @error('pastor_name') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Service Title</label>
                <input type="text" name="service_title" class="form-input" placeholder="e.g., Sunday Service, Midweek Worship">
                @error('service_title') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Verse/Scripture Reference</label>
                <input type="text" name="verse" class="form-input" placeholder="e.g., John 3:16">
                @error('verse') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Start Service
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeServiceSessionModal()">
                    <i class="bi bi-x"></i> Cancel
                </button>
            </div>
        </form>
    </div>

    <style>
        .modal { position: fixed; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 2000; }
        .modal-backdrop { position: absolute; inset: 0; background: rgba(0,0,0,0.5); }
        .modal-content { position: relative; background: white; border-radius: 12px; max-width: 540px; width: 100%; padding: 0; box-shadow: 0 10px 30px rgba(0,0,0,0.2); z-index: 2; }
        .modal-header { display:flex; justify-content:space-between; align-items:center; padding:20px; border-bottom:1px solid var(--border); }
        .modal-close { background:transparent; border:none; font-size:22px; cursor:pointer; }
        .service-session-modal { padding: 20px; }
        .service-session-modal form { display:flex; flex-direction:column; gap:12px; }
        .form-group { display:flex; flex-direction:column; }
        .form-label { font-size:13px; font-weight:600; margin-bottom:6px; }
        .form-input { padding:10px 12px; border:1px solid var(--border); border-radius:8px; }
        .form-actions { display:flex; gap:12px; margin-top:12px; padding-top:12px; border-top:1px solid var(--border); }
        @media (max-width:768px) { .modal-content { width:95%; } .form-actions { flex-direction:column; } }
    </style>

    <script>
        function openServiceSessionModal() {
            const modal = document.getElementById('serviceSessionModal');
            if (!modal) return;
            modal.style.display = 'flex';
            // set default datetime
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const input = modal.querySelector('input[name="session_date"]');
            if (input) input.value = `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        function closeServiceSessionModal() {
            const modal = document.getElementById('serviceSessionModal');
            if (!modal) return;
            modal.style.display = 'none';
        }

        document.addEventListener('click', function (e) {
            const modal = document.getElementById('serviceSessionModal');
            if (!modal) return;
            if (e.target === modal) closeServiceSessionModal();
        });
    </script>
</div>
