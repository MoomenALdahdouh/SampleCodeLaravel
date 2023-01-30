$(function () {
    const table = $('#kt_ecommerce_products_table'),
        language = $('#language').val(),
        app_url = $('#app_url').val();
    $(document).ready(function () {
        "use strict";
        get_products();
        pin_status();
        /*Table Actions*/
        $(document).on('click', '#delete', function () {
            let id = $(this).data('id');
            confirm_delete(id);
        });
    });

    function pin_status() {
        $(document).on('click', '#pin_status', function () {
            let id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: app_url + "/admin/products/pin_status/" + id,
                success: function (response) {
                    if (response['success']) {
                        Swal.fire({
                            text: language === "en" ? "You have change order status!.":"لقد قمت بتغيير الحالة !.",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                            customClass: {confirmButton: "btn fw-bold btn-primary"}
                        });
                        id = "";
                        table.DataTable().ajax.reload();
                    } else if (response['error']) {
                        Swal.fire({
                            text: language === "en" ? "The order status was not change.":"لم تتغير حالة الطلب.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                            customClass: {confirmButton: "btn fw-bold btn-primary"}
                        });
                        id = "";
                    }
                }
            });
        });
    }

    function confirm_delete(id) {
        Swal.fire({
            text: language === "en" ? "Are you sure you want to delete this item?" : "هل أنت متأكد أنك تريد حذف هذا البند؟",
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: language === "en" ? "Yes, delete!" : "نعم ، احذف!",
            cancelButtonText: language === "en" ? "No, cancel" : "لا ، إلغاء",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        });
        var confirm_delete = document.getElementsByClassName("swal2-confirm");
        confirm_delete[0].addEventListener('click', function () {
            delete_product(id);
        });
    }

    function delete_product(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            url: app_url + "/admin/products/delete/" + id,
            success: function (response) {
                if (response['success']) {
                    Swal.fire({
                        text: language === "en" ? "You have deleted the item!." : "لقد قمت بحذف العنصر !.",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                        customClass: {confirmButton: "btn fw-bold btn-primary"}
                    });
                    table.DataTable().ajax.reload();
                } else if (response['error']) {
                    Swal.fire({
                        text: language === "en" ? "The item was not deleted." : "لم يتم حذف العنصر.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                        customClass: {confirmButton: "btn fw-bold btn-primary"}
                    });
                }
            }
        });
    }

    function get_products() {
        var KTAppEcommerceProducts = function () {
            var t, e, o = () => {
                t.querySelectorAll('[data-kt-ecommerce-product-filter="delete_row"]').forEach((t => {
                    t.addEventListener("click", (function (t) {
                        t.preventDefault();
                        const o = t.target.closest("tr"),
                            n = o.querySelector('[data-kt-ecommerce-product-filter="product_name"]').innerText;
                        Swal.fire({
                            text: "Are you sure you want to delete " + n + "?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: language === "en" ? "Yes, delete!" : "نعم ، احذف!",
                            cancelButtonText: language === "en" ? "No, cancel" : "لا ، إلغاء",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then((function (t) {
                            t.value ? Swal.fire({
                                text: "You have deleted " + n + "!.",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                                customClass: {confirmButton: "btn fw-bold btn-primary"}
                            }).then((function () {
                                e.row($(o)).remove().draw()
                            })) : "cancel" === t.dismiss && Swal.fire({
                                text: n + " was not deleted.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                                customClass: {confirmButton: "btn fw-bold btn-primary"}
                            })
                        }))
                    }))
                }))
            };
            return {
                init: function () {
                    (t = document.querySelector("#kt_ecommerce_products_table")) && ((e = $(t).DataTable({
                        order: [[0, "asc"]],
                        searchable: true,
                        ajax: {
                            "url": app_url + "/admin/products",
                            "type": 'GET',
                        },
                        columns: [
                            {
                                data: 'id',
                                name: 'id',
                            },
                            {
                                data: 'name',
                                name: 'name',
                            },
                            {
                                data: 'type',
                                name: 'type',
                            },
                            {
                                data: 'quantity',
                                name: 'quantity',
                            },
                            {
                                data: 'price',
                                name: 'price',
                            },
                            {
                                data: 'category',
                            }, {
                                data: 'status',
                                name: 'status',
                            },  {
                                data: 'pin_status',
                                name: 'pin_status',
                            }, {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ], "columnDefs": [{
                            "render": function (data, type, full, meta) {
                                return meta.row + 1; // adds id to serial no
                            },
                            "targets": 0
                        }],
                    })).on("draw", (function () {
                        o()
                    })), document.querySelector('[data-kt-ecommerce-product-filter="search"]').addEventListener("keyup", (function (t) {
                        e.search(t.target.value).draw()
                    })), (() => {
                        const t = document.querySelector('[data-kt-ecommerce-product-filter="status"]');
                        $(t).on("change", (t => {
                            let o = t.target.value;
                            "all" === o && (o = ""), e.column(4).search(o).draw()
                        }))
                    })(), o())
                }
            }
        }();
        KTUtil.onDOMContentLoaded((function () {
            KTAppEcommerceProducts.init()
        }));

    }
});
