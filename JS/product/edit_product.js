$(function () {
    const language = $('#language').val(),
        submit_button = document.getElementById("kt_ecommerce_add_product_submit"),
        a = document.getElementById("kt_ecommerce_add_product_status_datepicker"),
        e = document.getElementById("kt_ecommerce_add_product_status"),
        t = document.getElementById("kt_ecommerce_add_product_status_select"),
        product_name_input = $("#product_name"),
        image_file_input = $("#image_file_input"),
        product_name_en_input = $("#product_name_en"),
        uploaded_image_input = $("#uploaded_image"),
        product_description_input = $("#product_description"),
        product_description_en_input = $("#product_description_en"),
        product_price_input = $("#product_price"),
        product_quantity_input = $("#product_quantity"),
        meta_title_input = $("#meta_title"),
        meta_title_en_input = $("#meta_title_en"),
        meta_description_input = $("#meta_description"),
        meta_description_en_input = $("#meta_description_en"),
        product_categories_input = $("#product_categories"),
        /*product_discount_percentage_input = $("#kt_ecommerce_add_product_discount_label"),
        product_discount_fixed_input = $("#product_discount_fixed"),*/
        add_product_form = $("#kt_ecommerce_add_product_form"),
        product_media_error = $("#product_media_error"),
        variation_error = $("#variation_error"),
        status_type = ["bg-success", "bg-warning", "bg-danger"];

    let product_status = 1,
        discount_type = 0,
        id = $("#item_id").val(),
        image_updated = 0,
        myDropzone,
        app_url = $('#app_url').val();

    $(document).ready(function () {
        product_options();
        status_product();
        edit_product();
        product_old_media();
        image_update();
    });

    function product_old_media() {
        $(".old_media").each(function (index, value) {
            let id = $(this).attr("data-id");
            let name = $(this).attr("data-name");
            let mockFile = {name: name, size: "12300"};
            let path = $(this).attr("value");
            console.log(name + " :: " + path + " :: " + id);
            myDropzone.displayExistingFile(mockFile, path);
        });
    }

    function edit_product() {
        submit_button.addEventListener('click', function () {
            let product_name = product_name_input.val(),
                product_name_en = product_name_en_input.val(),
                product_description = product_description_input.val(),
                product_description_en = product_description_en_input.val(),
                //Product Price and quantity
                product_price = product_price_input.val(),
                product_quantity = product_quantity_input.val(),
                //Meta Tag
                meta_title = meta_title_input.val(),
                meta_title_en = meta_title_en_input.val(),
                meta_description = meta_description_input.val(),
                meta_description_en = meta_description_en_input.val(),
                //Product categories
                product_categories = product_categories_input.val(),
                //Product image and media
                product_image = prepare_image_base64(uploaded_image_input.css('background-image')),
                product_media = product_media_base64(),
                //variation
                product_variation = product_variations(),
                product_type = product_type_by_variation(product_variation)
            //product discount
            //discount_value = product_discount_value();

            /*Check if media gallery number is down 4 image*/
            if (!media_size(product_media))
                return;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: app_url+"/admin/products/edit/update/" + id,
                data: {
                    product_name: product_name,
                    product_name_en: product_name_en,
                    product_description: product_description,
                    product_description_en: product_description_en,
                    status: product_status,
                    product_image: product_image,
                    image_updated: image_updated,
                    product_media: product_media,
                    product_price: product_price,
                    product_categories: product_categories,
                    /*discount_value: discount_value,
                    discount_type: discount_type,*/
                    product_variation: product_variation,
                    product_type: product_type,
                    product_quantity: product_quantity,
                    meta_title: meta_title,
                    meta_title_en: meta_title_en,
                    meta_description: meta_description,
                    meta_description_en: meta_description_en,
                },
                success: function (response) {
                    if ($.isEmptyObject(response.error)) {
                        success_submit(response.success);
                    } else {
                        failed_submit(response.error);
                    }
                }
            });
        });
    }

    function product_type_by_variation(product_variation) {
        if (product_variation.length <= 0)
            return 0;
        else
            return 1;
    }

    function product_discount_value() {
        switch (discount_type) {
            case 2:
                return product_discount_fixed_input.val();
            case 1:
                return product_discount_percentage_input.html();
            case 0:
                return 0;
        }
    }

    function Variation(id, index, name, name_en, price) {
        this.id = id;
        this.index = index;
        this.name = name;
        this.name_en = name_en;
        this.price = price;
    }

    function product_variations() {
        let variations = [];
        variation_error.html("");
        $(".variation_item").each(function (index, value) {
            //let image = prepare_image_base64(value.getAttribute("src"));
            let id = $(this).children(".variation_id").val();
            let name = $(this).children(".variation_name").val();
            let name_en = $(this).children(".variation_name_en").val();
            let price = $(this).children(".variation_price").val();
            let variation = new Variation(id, index, name, name_en, price);
            if (name)
                variations.push(variation);

        });
        return variations;
    }

    function prepare_image_base64(image) {
        image = image.replace('url("data:image/jpeg;base64,', '');
        image = image.replace('url("data:image/jpeg;base64,', '');
        image = image.replace('url("data:image/png;base64,', '');
        image = image.replace('url("data:image/jpg;base64,', '');
        image = image.replace('")', '');
        if (image == "none") {
            return "";
        } else
            return image;
    }

    function product_media_base64() {
        let product_media = [];
        product_media_error.html("")
        $(".dz-image img").each(function (index, value) {
            let image = prepare_image_base64(value.getAttribute("src"));
            product_media.push(image);
        });
        return product_media;
    }

    function media_size(product_media) {
        if (product_media.length > 6) {
            product_media_error.html("Just sex media galleries allowed!");
            failed();
            $('html, body').animate({scrollTop: $('#back_here').offset().top}, 'slow');
            return false;
        } else {
            product_media_error.html("");
            return true;
        }
    }

    function failed() {
        (submit_button.setAttribute("data-kt-indicator", "on"), submit_button.disabled = !0, setTimeout((function () {
            submit_button.removeAttribute("data-kt-indicator"), Swal.fire({
                text: language === "en" ? "Sorry, looks like there are some errors detected, please try again." : "معذرة ، يبدو أنه تم اكتشاف بعض الأخطاء ، يرجى المحاولة مرة أخرى.",
                icon: "error",
                buttonsStyling: !1,
                confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                customClass: {confirmButton: "btn btn-primary"}
            })
            submit_button.disabled = !1
        }), 1000));
    }

    function product_pricing() {
        const e = document.querySelectorAll('input[name="discount_option"]'),
            t = document.getElementById("kt_ecommerce_add_product_discount_percentage"),
            o = document.getElementById("kt_ecommerce_add_product_discount_fixed");
        e.forEach((e => {
            e.addEventListener("change", (e => {
                switch (e.target.value) {
                    case"2":
                        t.classList.remove("d-none"), o.classList.add("d-none");
                        discount_type = 1;
                        break;
                    case"3":
                        t.classList.add("d-none"), o.classList.remove("d-none");
                        discount_type = 2;
                        break;
                    default:
                        discount_type = 0;
                        t.classList.add("d-none"), o.classList.add("d-none")
                }
            }))
        }));
    }

    function pricing_slider() {
        var o, a;
        o = document.querySelector("#kt_ecommerce_add_product_discount_slider"), a = document.querySelector("#kt_ecommerce_add_product_discount_label"), noUiSlider.create(o, {
            start: [product_discount_percentage_input.html()],
            connect: !0,
            range: {min: 1, max: 100}
        }), o.noUiSlider.on("update", (function (e, t) {
            a.innerHTML = Math.round(e[t]), t && (a.innerHTML = Math.round(e[t]))
        }));
    }

    function product_options() {
        const e = () => {
            $("#kt_ecommerce_add_product_options").repeater({
                initEmpty: !1,
                defaultValues: {"text-input": "foo"},
                show: function () {
                    $(this).slideDown(), t()
                },
                hide: function (e) {
                    $(this).slideUp(e)
                }
            })
        }, t = () => {
            document.querySelectorAll('[data-kt-ecommerce-catalog-add-product="product_option"]').forEach((e => {
                $(e).hasClass("select2-hidden-accessible") || $(e).select2({minimumResultsForSearch: -1})
            }))
        };
        e(), myDropzone = new Dropzone("#kt_ecommerce_add_product_media", {
            url: "https://keenthemes.com/scripts/void.php",
            paramName: "file",
            maxFiles: 10,
            maxFilesize: 10,
            addRemoveLinks: !0,
            accept: function (e, t) {
                "wow.jpg" == e.name ? t("Naha, you don't.") : t()
            }
        });
    }

    function print_error(errors) {
        $.each(errors, function (index, val) {
            $("#" + index + "_error").html(val);
            //start switch tabs and focus errors
            if (index.indexOf("quantity") >= 0) {
                switch_second_tab();
            } else {
                switch_first_tab();
            }
            //end switch tabs and focus errors
            $("#" + index).focus();
        });
    }

    function switch_second_tab() {
        $("#advanced_tap").addClass("active")
        $("#kt_ecommerce_add_product_advanced").addClass("active show");
        $("#general_tap").removeClass("active")
        $("#kt_ecommerce_add_product_general").removeClass("active show");
    }

    function switch_first_tab() {
        $("#advanced_tap").removeClass("active")
        $("#kt_ecommerce_add_product_advanced").removeClass("active show");
        $("#general_tap").addClass("active")
        $("#kt_ecommerce_add_product_general").addClass("active show");
    }

    function status_product() {
        const c = () => {
            a.parentNode.classList.remove("d-none")
        }, r = () => {
            a.parentNode.classList.add("d-none")
        }
        $(t).on("change", (function (t) {
            switch (t.target.value) {
                case"published":
                    product_status = 1;
                    e.classList.remove(...status_type), e.classList.add("bg-success"), r();
                    break;
                case"scheduled":
                    e.classList.remove(...status_type), e.classList.add("bg-warning"), c();
                    break;
                case"unpublished":
                    product_status = 0;
                    e.classList.remove(...status_type), e.classList.add("bg-danger"), r()
            }
        }));
    }

    function success_submit(id) {
        //Success Submit
        $(".errors").html("");
        add_product_form.attr("data-kt-redirect", app_url+"/admin/products");
        (submit_button.setAttribute("data-kt-indicator", "on"), submit_button.disabled = !0, setTimeout((function () {
            submit_button.removeAttribute("data-kt-indicator"), Swal.fire({
                text: language === "en" ? "Form has been successfully submitted!" : "تم تقديم النموذج بنجاح!",
                icon: "success",
                buttonsStyling: !1,
                confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                customClass: {confirmButton: "btn btn-primary"}
            }).then((function (e) {
                e.isConfirmed && (submit_button.disabled = !1, window.location = add_product_form.attr("data-kt-redirect"))
            }))
            submit_button.disabled = !1
        }), 1000));//2e3 == 1000
    }

    function failed_submit(errors) {
        //Failed Submit
        $(".errors").html("");
        (submit_button.setAttribute("data-kt-indicator", "on"), submit_button.disabled = !0, setTimeout((function () {
            submit_button.removeAttribute("data-kt-indicator"), Swal.fire({
                text: language === "en" ? "Sorry, looks like there are some errors detected, please try again." : "معذرة ، يبدو أنه تم اكتشاف بعض الأخطاء ، يرجى المحاولة مرة أخرى.",
                icon: "error",
                buttonsStyling: !1,
                confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                customClass: {confirmButton: "btn btn-primary"}
            })
            submit_button.disabled = !1
            print_error(errors);
        }), 1000));
    }

    function image_update() {
        image_file_input.on('change', function (ev) {
            image_updated = 1;
        });
    }

    function add_variation() {
        $("#add_variation").on('click', function () {

        });
    }
});
