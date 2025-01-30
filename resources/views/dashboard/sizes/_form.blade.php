<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- Account -->
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <x-form.input label="الاسم" :value="$sizes->name" name="name" required autofocus />
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="الوحدة" :value="$sizes->unit" name="unit" required autofocus />
                    </div>

                    <!-- <div class="mb-4 col-md-6">
                        <x-form.input type="text" label="الوحدة" :value="$sizes->unit" name="unit" placeholder="الوحدة" required />
                    </div> -->
                
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-3">
                        {{ $btn_label ?? 'أضف' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
