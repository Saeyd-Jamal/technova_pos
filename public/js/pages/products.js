/**
 * App Invoice List (jquery)
 */

"use strict";

$(function () {
    // Variable declaration for table
    var dt_invoice_table = $(".invoice-list-table");

    // Invoice datatable
    if (dt_invoice_table.length) {
        var dt_invoice = dt_invoice_table.DataTable({
            ajax: {
                url: urlIndex, // URL الخاص بالـ Controller
                type: 'GET', // أو POST حسب ما تستخدم
                dataSrc: 'data' // إذا كانت البيانات داخل كائن معين، حدد اسم الكائن هنا
            },
            columns: [
                { data: "DT_RowIndex" }, // العمود الأول: الفهرس (رقم الصف)
                { data: "id" }, // العمود الثاني: يستخدم للـ checkboxes
                { data: "id" }, // العمود الثاني: يستخدم للـ checkboxes
                { data: "name" }, // اسم المنتج
                { data: "image" }, // صورة المنتج
                { data: "description" }, // وصف المنتج
                { data: "status" }, // حالة المنتج
                { data: "category_name" }, // اسم الفئة
                { data: "action" } // العمود الأخير: الأزرار (إجراءات)
            ],
            columnDefs: [
                {
                    // For Checkboxes
                    targets: 1,
                    orderable: false,
                    checkboxes: {
                        selectAllRender: '<input type="checkbox" class="form-check-input">',
                    },
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                    },
                    searchable: false,
                },
                {
                    // Product ID
                    targets: 2,
                    render: function (data, type, full, meta) {
                        let id = full["id"];
                        return `<a href="${urlView}">#${id}</a>;`.replace(":id", id);
                    },
                },
                {
                    // Name
                    targets: 3,
                    render: function (data, type, full, meta) {
                        return data;
                    },
                },
                {
                    // Image
                    targets: 4,
                    render: function (data, type, full, meta) {
                        return '<img src="storage/'+ data + '" alt="Product Image" width="50" height="50" style="object-fit: cover;">';
                    },
                },
                {
                    // Description
                    targets: 5,
                    render: function (data, type, full, meta) {
                        return data;
                    },
                },
                {
                    // Status
                    targets: 6,
                    render: function (data, type, full, meta) {
                        var statusClass = data === 'نشط' ? 'bg-success' : 'bg-secondary';
                        return '<span class="badge ' + statusClass + '">' + data + '</span>';
                    },
                },
                {
                    // Category Name
                    targets: 7,
                    render: function (data, type, full, meta) {
                        return data;
                    },
                },
                {
                    // Actions
                    targets: -1,
                    title: "الحدث",
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return `
                            <div class="d-flex align-items-center">
                            <a href="${urlView}" data-bs-toggle="tooltip" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill" data-bs-placement="top" title="Preview"><i class="ti ti-eye mx-2 ti-md"></i></a>
                            <a href="${urlEdit}" data-bs-toggle="tooltip" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill" data-bs-placement="top" title="Preview"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="javascript:;" data-id=":id" data-bs-toggle="tooltip" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill delete-record" data-bs-placement="top" title="Delete"><i class="ti ti-trash mx-2 ti-md"></i></a>
                            </div>
                        `.replace(':id', full.id).replace(':id', full.id).replace(':id', full.id);
                    },
                },
            ],
            order: [[2, "desc"]],
            dom:
                '<"row mx-1"' +
                '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start"B>>' +
                '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-5 gap-md-4 mt-n6 mt-md-0"f<"invoice_status mb-6 mb-md-0">>' +
                ">t" +
                '<"row mx-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                ">",
            language: {
                sLengthMenu: "عرض _MENU_",
                search: "",
                searchPlaceholder: "بحث عن المنتج",
                paginate: {
                    next: '<i class="ti ti-chevron-right ti-sm"></i>',
                    previous: '<i class="ti ti-chevron-left ti-sm"></i>',
                },
            },
            // Buttons with Dropdown
            buttons: [
                {
                    text: '<i class="ti ti-plus ti-xs me-md-2"></i><span class="d-md-inline-block d-none">إضافة منتج</span>',
                    className: "btn btn-primary waves-effect waves-light",
                    action: function (e, dt, button, config) {
                        window.location = urlCreate;
                    },
                },
            ],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return "Details of " + data["full_name"];
                        },
                    }),
                    type: "column",
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                      col.rowIndex +
                                      '" data-dt-column="' +
                                      col.columnIndex +
                                      '">' +
                                      "<td>" +
                                      col.title +
                                      ":" +
                                      "</td> " +
                                      "<td>" +
                                      col.data +
                                      "</td>" +
                                      "</tr>"
                                : "";
                        }).join("");

                        return data
                            ? $('<table class="table"/><tbody />').append(data)
                            : false;
                    },
                },
            },
            initComplete: function () {
                // Adding filter for status
                this.api()
                    .columns(6) // العمود السابع (status)
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select id="StatusFilter" class="form-select"><option value=""> Select Status </option></select>'
                        )
                            .appendTo(".invoice_status")
                            .on("change", function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? "^" + val + "$" : "", true, false).draw();
                            });
            
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' + d + '" class="text-capitalize">' + d + "</option>"
                                );
                            });
                    });
            },
        });
    }

    // On each datatable draw, initialize tooltip
    dt_invoice_table.on("draw.dt", function () {
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                boundary: document.body,
            });
        });
    });

    // Delete Record
    $(".invoice-list-table tbody").on("click", ".delete-record", function () {
        var id = $(this).data("id");
        if(confirm("هل أنت متأكد من حذف المنتج")){
            $.ajax({
                url: urlDestroy.replace(":id", id),
                type: "DELETE",
                data: {
                    id: id,
                    _token: token,
                },
                success: function (response) {
                    alert(response.message);
                    dt_invoice.row($(this).parents("tr")).remove().draw();
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", status, error);
                },
            })
        }

        
        dt_invoice.row($(this).parents("tr")).remove().draw();
    });

    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        $(".dataTables_filter .form-control").removeClass("form-control-sm");
        $(".dataTables_length .form-select").removeClass("form-select-sm");
    }, 300);


});
