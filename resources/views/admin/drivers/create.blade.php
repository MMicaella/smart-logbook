<x-app-layout>

<style>
    body {
        background:
            linear-gradient(rgba(25,0,0,0.88), rgba(10,0,0,0.95)),
            url('/images/osmena-logo.png');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }

    main {
        background: transparent !important;
    }

    nav, header {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .glass-wrapper {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(25px);
    }

    .glass-input {
        width: 100%;
        padding: 12px;
        border-radius: 14px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.12);
        color: white;
        outline: none;
        transition: 0.2s;
    }

    .glass-input:focus {
        border-color: rgba(255,80,80,0.6);
        box-shadow: 0 0 0 3px rgba(255,0,0,0.12);
    }

    .glass-label {
        display: block;
        margin-bottom: 6px;
        font-size: 0.85rem;
        color: rgba(255,255,255,0.7);
    }

    .btn-success {
        background: linear-gradient(to right, #14532d, #166534);
        color: white;
        padding: 12px 18px;
        border-radius: 14px;
        font-weight: 600;
        width: 100%;
        transition: 0.2s;
    }

    .btn-success:hover {
        transform: scale(1.02);
        background: linear-gradient(to right, #166534, #15803d);
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-4xl mx-auto px-4">

        <div class="glass-wrapper rounded-2xl p-8 text-white shadow-2xl">

            <!-- HEADER -->
            <h2 class="text-xl font-bold mb-6">
                Add Driver
            </h2>

            <!-- FORM -->
            <form method="POST" action="/admin/drivers/store">
                @csrf

                <!-- DOUBLE COLUMN GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- NAME -->
                    <div>
                        <label class="glass-label">Driver Name</label>
                        <input type="text"
                               name="name"
                               class="glass-input"
                               required>
                    </div>

                    <!-- LICENSE -->
                    <div>
                        <label class="glass-label">License Number</label>
                        <input type="text"
                               name="license_number"
                               class="glass-input"
                               required>
                    </div>

                    <!-- CONTACT -->
                    <div>
                        <label class="glass-label">Contact Number</label>
                        <input type="text"
                               name="contact_number"
                               class="glass-input"
                               required>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label class="glass-label">Status</label>

                        <select name="status"
                                class="glass-input">

                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>

                        </select>

                    </div>

                </div>

                <!-- BUTTON FULL WIDTH -->
                <div class="mt-6">
                    <button class="btn-success">
                        Add Driver
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

</x-app-layout>