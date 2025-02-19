@push('styles')
<style>
    th{
        font-size: 18px !important;
        font-weight: bold !important;
    }
</style>
@endpush
@if ($errors->any())
<div class="alert alert-danger">
    <h3> Ooops Error</h3>
    <ul>
        @foreach ($errors->all() as $key => $error )
            <li>{{$key . ' : ' .$error}}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body pt-4">
                <div class="row">
                    <h3>{{ isset($btn_label) ? "تعديل منتج " . $product->name : "اضافة منتج" }}</h3>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="الاسم" :value="$product->name" name="name" required autofocus />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="السعر" :value="$product->price" name="price" required />
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="qr_code" class="form-label mb-2">مسح qr</label>
                        <div class="input-group">
                            <button class="btn btn-outline-primary waves-effect" type="button" id="scan-btn">
                                <i class="fa fa-qrcode"></i>
                            </button>
                            <x-form.input :value="$product->qr_code" name="qr_code" readonly  aria-label="Example text with button addon" aria-describedby="scan-btn" />
                        </div>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="image">الصورة</label>
                        <input type="file" name="imageFile" class="form-control" />
                        @if ($product->image) <!-- تأكد من أن المتغير صحيح -->
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" height="60">
                        @endif
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="الوصف" :value="$product->description" name="description" />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.select label="الصنف" :defaultValue="$product->category_id" name="category_id" :optionsId="$categories" />
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="status" class="form-label">الحالة</label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-active" value="1" @checked(old('status', $product->status) == 'active' || old('status', $product->status) == null)>
                                <label class="form-check-label" for="status-active">نشط</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-inactive" value="0" @checked(old('status', $product->status) == 'archived')>
                                <label class="form-check-label" for="status-inactive">غير نشط</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>النكهات</h3>
                        <button type="button" class="btn btn-primary addFlavor">اضافة نكهة</button>
                    </div>
                    <div class="row">
                        @foreach($product->flavors as $index => $flavor)
                            <div class="card my-2 border border-primary" id="flavor-{{$index}}">
                                <div class="card-body row">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4>نكهة - <span>{{$index + 1}}</span></h4>
                                        <button type="button" class="btn btn-danger removeFlavor" data-index="{{$index}}">
                                            <i class="fa fa-x"></i>
                                        </button>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <x-form.input label="الاسم" value="{{$flavor->name}}"  name="name-{{$index}}" placeholder="محمد ...." required/>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <x-form.input label="الصورة للنكهة" type="file" name='image-{{$index}}'  placeholder="محمد ...."/>
                                    </div>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>الحجم</th>
                                                    <th>نوع الكمية</th>
                                                    <th>الكمية</th>
                                                    <th style="width: 10px;">
                                                        <button type="button" class="btn btn-primary addFlavorSize" data-index="{{$index}}">
                                                            <i class="ti ti-plus"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0" id="flavorSizes-{{$index}}">
                                                @foreach($flavor->stock as $index2 => $stock)
                                                    <tr id="flavorSize-{{$index2}}">
                                                        <td>
                                                            <input type="hidden" name="flavorSizes[{{$index}}][id]" value="{{$stock->id}}">
                                                            {{ $index2 + 1 }}
                                                        </td>
                                                        <td>
                                                            <x-form.select :optionsId="$sizes" :value="$stock->size_id" name="size-{{$index}}-{{$index2}}" required/>
                                                        </td>
                                                        <td>
                                                            <x-form.select :optionsId="$quantityTypes" :value="$stock->quantity_type_id" name="unit_type-{{$index}}-{{$index2}}" required/>
                                                        </td>
                                                        <td>
                                                            <x-form.input name="quantity-{{$index}}-{{$index2}}" type="number" style="width: 150px;" :value="$stock->quantity" required/>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger removeFlavorSize" data-index="{{$index2}}" data-flavor-index="{{$index}}">
                                                                <i class="ti ti-trash me-1"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="flavors">
                    </div>
                    <input type="hidden" name="flavors" id="flavorsArray">
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

@push('scripts')
<script>
    // Variables
    $(document).ready(function() {
        let flavors = [

        ];
        $('#flavorsArray').val(JSON.stringify(flavors));
        function addFlavor() {
            let i = flavors.length;
            const html =
                `<div class="card my-2 border border-primary" id="flavor-${i}">
                    <div class="card-body row">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>نكهة - <span>${i + 1}</span></h4>
                            <button type="button" class="btn btn-danger removeFlavor" data-index="${i}">
                                <i class="fa fa-x"></i>
                            </button>
                        </div>
                        <div class="mb-4 col-md-6">
                            <x-form.input label="الاسم"  name="name-${i}" placeholder="محمد ...." required/>
                        </div>
                        <div class="mb-4 col-md-6">
                            <x-form.input label="الصورة للنكهة" type="file" name='image-${i}'  placeholder="محمد ...."/>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الحجم</th>
                                        <th>نوع الكمية</th>
                                        <th>الكمية</th>
                                        <th style="width: 10px;">
                                            <button type="button" class="btn btn-primary addFlavorSize" data-index="${i}">
                                                <i class="ti ti-plus"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0" id="flavorSizes-${i}">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>`;
            $('#flavors').append(html);
            flavors.push({ sizes: 0 });
            $('#flavorsArray').val(JSON.stringify(flavors));
        };
        $(document).on('click', '.addFlavor', function() {
            console.log(flavors);
            addFlavor();
        });
        function  addFlavorSize(indexFlavors) {
            let i = flavors[indexFlavors].sizes;
            const html =
                `<tr class="flavor-size" id="flavorSize-${indexFlavors}-${i}">
                    <td>
                        ${i + 1}
                    </td>
                    <td>
                        <x-form.select :optionsId="$sizes" name="size-${indexFlavors}-${i}" required/>
                    </td>
                    <td>
                        <x-form.select :optionsId="$quantityTypes" name="unit_type-${indexFlavors}-${i}" required/>
                    </td>
                    <td>
                        <x-form.input name="quantity-${indexFlavors}-${i}" type="number" style="width: 150px;" required/>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger removeFlavorSize" data-index="${i}" data-flavor-index="${indexFlavors}">
                            <i class="ti ti-trash me-1"></i>
                        </button>
                    </td>
                </tr>`;
            $('#flavorSizes-' + indexFlavors).append(html);
            flavors[indexFlavors].sizes++;
            $('#flavorsArray').val(JSON.stringify(flavors));
        };
        $(document).on('click', '.addFlavorSize', function() {
            let index = $(this).data('index');
            addFlavorSize(index);
        });
        function removeFlavor(index) {
            $('#flavor-' + index).remove();
            flavors.splice(index, 1);
            $('#flavorsArray').val(JSON.stringify(flavors));
        };
        $(document).on('click', '.removeFlavor', function() {
            let index = $(this).data('index');
            removeFlavor(index);
        });
        function removeFlavorSize(indexFlavor, index) {
            $('#flavorSize-' + index).remove();
            flavors[indexFlavor].sizes--;
            $('#flavorsArray').val(JSON.stringify(flavors));
        };
        $(document).on('click', '.removeFlavorSize', function() {
            let index = $(this).data('index');
            let flavor_index = $(this).data('flavor-index');
            removeFlavorSize(flavor_index,index);
        });


        $('#scan-btn').click(function() {
            // هنا ستستخدم كاميرا الهاتف لمسح QR Code
            // يتم إدخال القيمة الممسوحة في الحقل

            // هذه المحاكاة لمسح QR بواسطة الهاتف أو جهاز ماسح QR يدوي
            var scannedQrCode = prompt("Scan the QR code value");  // محاكاة المسح

            if (scannedQrCode) {
                $('#qr_code').val(scannedQrCode);  // إدخال القيمة الممسوحة في الحقل
                // إرسال البيانات عبر AJAX
                // $.ajax({
                //     url: '/products',
                //     method: 'POST',
                //     data: {
                //         name: $('#product_name').val(),  // اسم المنتج
                //         qr_code: scannedQrCode,          // QR code
                //         _token: '{{ csrf_token() }}'      // تأكد من إضافة توكن CSRF
                //     },
                //     success: function(response) {
                //         alert(response.message);
                //     },
                //     error: function(error) {
                //         alert('Error adding product');
                //     }
                // });
            }
        });
    });
</script>
@endpush
