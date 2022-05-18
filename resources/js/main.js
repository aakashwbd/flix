// window.prototype = this;
require("./bootstrap");
var token = localStorage.getItem("accessToken") || null;
/***
 * Landing Scroll to Navbar changed background
 ***/
window.onscroll = function () {
    let navbar = document.querySelector("#siteNav");
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
};

// $("#siteNav").on("click", function () {
//     $("#siteNav-list").toggleClass("nav-show");
// });

var swiper = new Swiper(".partnerSwiper", {
    slidesPerView: 3,
    spaceBetween: 30,
    autoplay: true,
});

/***
 * HELPER FUNCTION
 ***/
setBirthYear = function (divID, defaultYear, minAge, maxAge) {
    $.dobPicker({
        yearSelector: divID,
        yearDefault: defaultYear,
        minimumAge: minAge,
        maximumAge: maxAge,
    });
};

/***
 * HELPER VARIABLES
 ***/
let constants = {
    getToken: localStorage.getItem("accessToken"),
    location: getCookie("COOKIE_LOCATION"),

    userSearchURL: "/api/search-user",
    fetchUserURL: "/api/user/get-all",
    fetchUnAuthUserURL: "/api/user/fetch-all",
    fetchSettingsURL: "/api/admin/setting/get-all",
};

/***
 * STARTUP ACTION
 ***/
// var getAge = []
$(document).ready(function () {
    $.ajax({
        url: window.origin + '/api/admin/setting/get-all',
        type: 'GET',
        dataType: "json",
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (res) {
            if (res.status === 'success' && res.data.length) {

                Object.entries(res.data[0]).forEach(value => {
                    if (value[0] === 'age') {

                        if (value[1]) {
                            var max_age = parseInt(value[1].max_age)
                            var min_age = parseInt(value[1].min_age)
                        }
                        getAge(max_age, min_age)
                    }
                })

            }

        }, error: function (jqXhr, ajaxOptions, thrownError) {
            console.log(jqXhr)
        }
    })

    getAge = function (max, min) {
        var maximumAge = max ? max : 100
        var minimumAge = min ? min : 10

        const age = {
            defaultYear: "Birth Year",
            minAge: minimumAge,
            maxAge: maximumAge,
        };

        setBirthYear("#dobyear", age.defaultYear, age.minAge, age.maxAge);
        setBirthYear("#infoBirthYear", age.defaultYear, age.minAge, age.maxAge);

        if (getCookie("COOKIE_AGE") || constants.getToken) {
            $.year = getCookie("COOKIE_AGE");
            setBirthYear("#inscriptionBirthYear", $.year, age.minAge, age.maxAge);
            $("#confirmModal").modal("hide");
        } else {
            $("#confirmModal").modal("show");
        }
    }


    // const age = {
    //     defaultYear: "Birth Year",
    //     minAge: 10,
    //     maxAge: 100,
    // };
    //
    // setBirthYear("#dobyear", age.defaultYear, age.minAge, age.maxAge);
    // setBirthYear("#infoBirthYear", age.defaultYear, age.minAge, age.maxAge);
    //
    // if (getCookie("COOKIE_AGE") || constants.getToken) {
    //     $.year = getCookie("COOKIE_AGE");
    //     setBirthYear("#inscriptionBirthYear", $.year, age.minAge, age.maxAge);
    //     $("#confirmModal").modal("hide");
    // } else {
    //     $("#confirmModal").modal("show");
    // }

    /**
     * AGE RESTRICTION
     ***/
    $(document).on("click", "#birthConfirmDialogBtn", function (e) {
        e.preventDefault();
        let birthYear = $("#dobyear").val();

        if (birthYear === "Birth Year") {
            let errMsg = $("#confirmErrMsg");
            errMsg.removeClass("d-none");
        } else {
            document.cookie =
                "COOKIE_AGE=" +
                birthYear +
                "; expires=" +
                new Date(86400000 + Date.now()).toUTCString() +
                ";";
            $("#confirmModal").modal("hide");
            $("#locationModal").modal("show");
        }
    });

    /**
     * LOCATION FORM
     */
    $(document).on("click", "#location-btn", function (e) {
        e.preventDefault();
        let location = $(".locationInput").val();

        if (location === "") {
            $(".locationError").removeClass("d-none");
        } else {
            document.cookie =
                "COOKIE_LOCATION=" +
                location +
                "; expires=" +
                new Date(86400000 + Date.now()).toUTCString() +
                ";";

            window.location.href = window.origin;
            $("#locationModal").modal("hide");
        }
    });


    if (!getCookie('COOKIE_LOCATION') && getCookie('COOKIE_AGE')) {
        $('#locationModal').modal('show')
    }

    /**
     * SET SEARCH ADDRESS BY COOKIE
     */
    if (constants.location) {
        $(".getLocation").val(constants.location);
    }

    /**
     * FETCH USER WHEN SEARCH FORM ADDRESS FIELD EMPTY
     */
    let searchFormAddress = $(".getLocation").val();

    let formData = new FormData();


    if (searchFormAddress === "") {
        let user = JSON.parse(localStorage.getItem("user"));

        if (user) {
            formData.append("id", user.id);
        }

        if (token) {
            $.ajax({
                type: "POST",
                url: window.origin + constants.fetchUserURL,
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    "Authorization": token,
                },
                success: function (response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        userList(response);
                        $('#searchResultHeading').text('Result for : all people around you ')
                    }
                },
                error: function (xhr, resp, text) {
                    console.log(xhr);
                },
            });
        } else {
            $.ajax({
                type: "POST",
                url: window.origin + "/api/user/fetch-all",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        userList(response);
                        $('#searchResultHeading').text('Result for : all people around you ')
                    }

                },
                error: function (xhr, resp, text) {
                    console.log(xhr);
                },
            });
        }
    } else {
        formData.append("address", searchFormAddress);
        $.ajax({
            type: "POST",
            url: window.origin + constants.userSearchURL,
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Authorization": token,
            },
            success: function (response) {
                if (response.status === "success" && response.data.length > 0) {
                    userList(response);
                    $('#searchResultHeading').text('Result : People around - ' + searchFormAddress)
                } else {
                    $('#searchResultHeading').text('There are no people around - ' + searchFormAddress)
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
});

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


/**
 * GET & SET BANNER IMAGE TO HOME & ADS
 */
$(document).ready(function () {
    const images = [];
    $.ajax({
        url: window.origin + "/api/admin/banner-image/index",
        type: "GET",
        dataType: "json",
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (res) {
            let bannerImg = document.querySelector(".bannerImg");
            if (res.status === "success" && res.data.length > 0) {
                res.data.forEach((item) => {
                    images.push(item.image);
                });
                bannerImg.src =
                    images[Math.floor(Math.random() * images.length)];
            } else if (res.status === "success" && res.data.length === 0) {
                if (bannerImg) {
                    bannerImg.src = window.origin + '/asset/image/banner.jpg'
                }
            }
        },
        error: function (jqXhr, ajaxOptions, thrownError) {
            console.log(jqXhr);
        },
    });
});

//

formSubmit = function (type, form, token = null) {
    let form_data = JSON.stringify(form.serializeJSON());
    let formData = JSON.parse(form_data);

    if (formData.emailorphone) {
        let data = {
            email: null,
            phone: null,
        };
        let emailRegex =
            /(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/;
        if (emailRegex.test(formData.emailorphone)) {
            data.email = formData.emailorphone;
            formData.email = data.email;
        } else {
            data.phone = formData.emailorphone;
            formData.phone = data.phone;
        }
    }

    if (formData.dob) {
        let now = new Date().getFullYear();
        formData.age = now - formData.dob;
    }


    let url = form.attr("action");


    $.ajax({
        type: type,
        url: url,
        data: formData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Authorization": token,
        },
        success: function (response) {

            if (
                response.status === "success" &&
                response.form === "registration"
            ) {
                toastr.success(response.message);
                location.reload();
            }

            if (response.status === "success" && response.form === "login") {
                toastr.success(response.message);
                localStorage.setItem("accessToken", response.data.token);
                localStorage.setItem(
                    "user",
                    JSON.stringify(response.data.user)
                );
                $("#loginModal").modal("hide");
                location.reload();
            }

            if (response.form === "recoverForm") {
                if (response.data) {
                    $("#recoverPasswordForm").removeClass("d-none");
                    $("#recoverForm").addClass("d-none");
                    if (response.data.email) {
                        $("#recoverEmailHiddenInput").val(response.data.email);
                    } else if (response.data.phone) {
                        $("#recoverPhoneHiddenInput").val(response.data.phone);
                    }
                } else {
                    $("#forgetFromEmailOrPhone").text("Please Register First");
                }
            }

            if (response.form === "passwordChanged") {
                toastr.success(response.message);
                location.reload()
            }


            if (
                response.status === "success" &&
                response.action === "search-user"
            ) {

                $("#homeSearchListContainer").html("");
                userList(response);

            }

            if (
                response.status === "success" &&
                response.action === "category-list"
            ) {
                categoryList(response);
                location.reload()
            }

            if (
                response.status === "success" &&
                response.data.token &&
                response.data.user.user_role_id === 1 &&
                response.data.user.user_role_id === 2
            ) {
                localStorage.setItem("adminAccessToken", response.data.token);
                localStorage.setItem(
                    "admin",
                    JSON.stringify(response.data.user)
                );
                window.location.href = window.origin + "/admin";
                location.reload()
            }

            toastr.success(response.message);
            location.reload()
        },
        error: function (xhr, resp, text) {
            console.log(xhr);
            if (xhr && xhr.responseJSON) {
                let response = xhr.responseJSON;
                if (response.status && response.status === "validate_error") {
                    $.each(response.message, function (index, message) {
                        $("." + message.field).addClass("is-invalid");
                        $("." + message.field + "_label").addClass(
                            "text-danger"
                        );
                        $("." + message.field + "_error").html(message.error);
                    });
                }
            }
        }
    });
};

clearError = function (input) {
    $("#" + input.id).removeClass("is-invalid");
    $("#" + input.id + "_label").removeClass("text-danger");
    $("#" + input.id + "_icon").removeClass("text-danger");
    $("#" + input.id + "_icon_border").removeClass("field-error");
    $("#" + input.id + "_error").html("");
};
$("#signOut").click(function () {

    var userActivity = localStorage.getItem('accessToken')

    if (userActivity) {
        $.ajax({
            url: window.origin + "/api/user-activity-check",
            method: "patch",
            data: {
                "status": false
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": userActivity
            },
            success: function (res) {
                console.log(res)
            },
            error: function (err) {
                console.log(err)
            }

        })
    }
    localStorage.removeItem("accessToken");
    localStorage.removeItem("user");
    location.href = window.origin


});


uploader = function (
    event,
    type = null,
    step = null,
    inputHidden = null,
    previewImg = null,
    privacyForm = null,
    waitMsg = null,
) {
    event.preventDefault();
    var file = event.target.files[0];

    let formData = new FormData();
    formData.append("file", file);
    formData.append("folder", "video");

    var showurl = window.origin + "/api/image-uploader";
    $.ajax({
        url: showurl,
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        beforeSend: function () {
            $('#preloader').removeClass('d-none');
            $('#submit-button').prop('disabled', true);
            $('#update-button').prop('disabled', true);
            $("#" + waitMsg).removeClass("d-none");
        },
        success: function (res) {
            $("#" + inputHidden).val(res.data);
            $("#" + previewImg)
                .removeClass("d-none")
                .attr("src", res.data);
            $("#" + privacyForm).removeClass("d-none");
            toastr.success("File Upload successfully");
        },
        error: function (jqXhr, ajaxOptions, thrownError) {
            console.log(jqXhr);
        },
        complete: function (xhr, status) {
            $("#" + waitMsg).addClass("d-none");
            $('#preloader').addClass('d-none');
            $('#submit-button').prop('disabled', false);
            $('#update-button').prop('disabled', false);
        },
    });
};

$(document).on("click", ".star", function () {
    let value = $(".star").attr("data-rating-value");
    let id = $(".star").attr("data-video-id");
    let formData = new FormData();
    formData.append("rating", value);

    $.ajax({
        url: window.origin + "/api/video/id".replace("id", id),
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        success: function (res) {
        },
        error: function (jqXhr, ajaxOptions, thrownError) {
            console.log(jqXhr);
        },
    });
});

getShowData = function (url) {
    $.ajax({
        type: "GET",
        url: url,
        success: function (response) {
            categoryList(response);
        },
        error: function (err) {
            console.log(err);
        },
    });
};

categoryList = function (res) {
    res.data.forEach((item) => {
        $("#categoryList").append(`
            <li class="col-3">
            <div class="card position-relative">
                <span class="iconify editCategory" data-bs-target="#editCategoryModal" data-bs-toggle="modal" data-id="${item.id}" data-icon="bxs:edit" data-width="20" data-height="20"></span>
                <img src="https://th.bing.com/th/id/OIP.FcUYoInKYogVky8OJn08lgHaLH?pid=ImgDet&rs=1" class="card-img-top" alt="">
                <div class="card-body">
                    <h2>52</h2>
                    <span>${item.name}</span>
                </div>
            </div>

        </li>
        `);
    });
};

$(document).on("click", ".editCategory", function () {
    let id = $(".editCategory").attr("data-id");
});

userList = function (res) {
    let getUserInfo = JSON.parse(localStorage.getItem('user'))


    let date = new Date();
    let currentDate = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + date.getFullYear()


    res.data.forEach((item) => {
        let img = window.origin + '/images/Default_Image_Thumbnail.png'
        if (item.image) {
            img = item.image
        }

        let getDate = new Date(item.created_at);
        let createdDate = ((getDate.getMonth() > 8) ? (getDate.getMonth() + 1) : ('0' + (getDate.getMonth() + 1))) + '-' + ((getDate.getDate() > 9) ? getDate.getDate() : ('0' + getDate.getDate())) + '-' + getDate.getFullYear()


        $("#message-box").append(`
            <div class="messenger d-none" id="messenger${item.id}">
                <div class="header">
                    <img style="width: 40px; height: 40px;" src="${img}" alt="">
                    <span class="messenger-username text-white">${item.username ? item.username : ""}</span>
                    <span class="iconify cursor-pointer" onclick="closeMessenger()" data-icon="ep:close-bold" data-width="20" data-height="20"></span>
                </div>

                <ul class="body" id="messages${item.id}"></ul>

                <form class="footer" id="messageForm${item.id}" >
                    <input type="hidden" value="${item.id}" id="messenger-to-userid${item.id}" class="messenger-to-userid">

                    <input type="text" class="form-control" placeholder="write your message...." id="message_input${item.id}">

                    <button class="btn" type="submit" id="message-submit-button${item.id}">
                        <span class="iconify text-primary" data-icon="bi:send-fill" data-width="20" data-height="20"></span>
                    </button>
                </form>
            </div>
        `);


        $("#homeSearchListContainer").append(`
        <li class="list-item border-bottom py-2 restrictedList ">
                    <div class="row">
                        <div class="col-lg-1 col-sm-4 col-4">
                            <a href="JavaScript:void(0)" onclick="visitProfile(${
            item.id
        })">
                                    <img id="userImage${
            item.id
        }" class="userListProfileImg profile__image img-blur"
                                 src="${img}"
                                 alt="">
                             </a>
                        </div>
                        <div class="col-lg-8 col-sm-6 col-6">
                            <div class="d-flex align-items-center mb-3">
                            ${item.address ?
            (`<span class="iconify me-3 text-primary" data-icon="entypo:location" data-width="30" data-height="30"></span>
                                 <span id="user-address">${item.address}</span>
                                 <span class="mx-3">|</span>`) : ""
        }
                            ${currentDate > createdDate ? '' : (`
                                <span class="iconify text-danger" data-icon="clarity:new-solid" data-width="20" data-height="20"></span>
                            `)}

                            </div>

                            <div class="d-flex align-items-center">

                               <span class="iconify ${item.online_status ? 'text-success' : 'text-warning'} me-3" data-icon="carbon:dot-mark" data-width="20" data-height="20"></span>


                                ${item.username ? (`
                                    <span id="user-name" class="me-3">${item.username}</span>
                                `) : ''}

                                ${item.age ? (`
                                    <span class="me-3">${item.age}y.o</span>
                                `) : ''}


                            </div>

                        </div>
                        <div class="col-lg-3 col-sm-12 col-12" id="extraCol${item.id}">
                            <ul class="extra-list userListExtraMenu" id="userListExtraMenu${item.id}">
                                <li class="extra-list-item">
                                    <span
                                        id="messengerIcon${item.id}"
                                        data-event="message"
                                        data-userid='${item.id}'
                                        class="iconify user-message-icon cursor-pointer extra-list-link authAction"
                                        data-icon="bxs:message-rounded"
                                        data-width="30"
                                        data-height="30" onclick="messenger('messengerIcon${
            item.id
        }', ${item.id})"></span>
                                </li>

                                <li class="extra-list-item">
                                    <span
                                        id="flashIcon${item.id}"
                                        data-event="flash"
                                        data-user-id = ${item.id}
                                        class="iconify cursor-pointer extra-list-link  flashIcon"
                                        data-icon="carbon:flash-filled"
                                        data-width="30"
                                        data-height="30"
                                        ></span>
                                </li>

                                <li class="extra-list-item dropdown">
                                    <span
                                        data-bs-toggle="dropdown"
                                        data-event="more-action"
                                        class="iconify cursor-pointer extra-list-link  more-icon more-action"
                                        data-icon="fluent:add-square-24-filled"
                                        data-width="30"
                                        data-height="30"
                                        id="moreIcon${item.id}"

                                        ></span>


                                    <ul class="dropdown-menu dropdown-menu-end p-2">
                                        <li class="dropdown-item">
                                            <button id="favourite-submit-button${item.id}" onclick="favouriteHandler(${
            item.id
        })" class="btn form-control text-capitalize">
                                                <span
                                                    class="iconify
                                                    ${
            item.is_favourite
                ? "text-primary"
                : null
        }"
                                                    data-icon="ic:round-favorite"
                                                    data-width="20"
                                                    data-height="20"></span>
                                                <span>${item.is_favourite ? "Unfavorite" : 'favorite'}</span>
                                            </button>
                                        </li>
                                        <li class="dropdown-divider"></li>

                                        <li class="dropdown-item">
                                            <button onclick="mapHandler(${
            item.id
        })"  class="btn form-control text-capitalize">
                                    <span class="iconify"  data-icon="bxs:map-pin" data-width="20"
                                          data-height="20"></span>
                                                <span>map</span>
                                            </button>
                                        </li>
                                        <li class="dropdown-divider"></li>

                                        <li class="dropdown-item">
                                            <button onclick="alertHandler(${
            item.id
        })" class="btn form-control text-capitalize" data-bs-toggle="modal"
                                                    data-bs-target="#alertModal">
                                    <span class="iconify" data-icon="akar-icons:triangle-alert-fill" data-width="20"
                                          data-height="20"></span>
                                                <span>alert</span>
                                            </button>


                                        </li>
                                        <li class="dropdown-divider"></li>

                                        <li class="dropdown-item">
                                            <button id="block-submit-button${item.id}" onclick="blockHandler(${
            item.id
        })" class="btn form-control text-capitalize">
                                    <span class="iconify" data-icon="akar-icons:block" data-width="20"
                                          data-height="20"></span>
                                                <span>${item.is_blocked ? "Unblock" : 'block'}</span>
                                            </button>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
        `);

        let image = document.querySelectorAll("#userImage" + item.id);
        let flashIcon = document.querySelectorAll("#flashIcon" + item.id);
        let moreIcon = document.querySelectorAll("#moreIcon" + item.id);
        authAction(image, flashIcon, moreIcon);

        if (getUserInfo) {
            if (getUserInfo.id && item.id === getUserInfo.id) {
                $('#extraCol' + item.id).addClass('d-none')

            }
        }

    });


};

visitProfile = function (userid) {
    let token = localStorage.getItem("accessToken");

    if (token) {
        window.location.href = window.origin + "/member/profile/" + userid;
        let formData = new FormData();
        formData.append("visitor_id", userid);

        $.ajax({
            url: window.origin + "/api/profile/visit",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Authorization: token,
            },
            success: function (res) {
                toastr.success(res.message);
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                console.log(jqXhr);
            },
        });
    } else {
        $("#loginModal").modal("show");
    }
};

favouriteHandler = function (userId) {
    let token = localStorage.getItem("accessToken");

    if (token) {
        let formData = new FormData();
        formData.append("favourite_user_id", userId);
        $.ajax({
            url: window.origin + "/api/favourite/store",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Authorization: token,
            },
            beforeSend: function () {
                $('#favourite-submit-button' + userId).prop('disabled', true);
                $('#preloader').removeClass('d-none');
            },
            success: function (res) {
                toastr.success(res.message);
                location.reload()
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                console.log(jqXhr);
            },
            complete: function (xhr, status) {

                $('#preloader').addClass('d-none');
                $('#favourite-submit-button' + userId).prop('disabled', false);
            }
        });
    } else {
        $("#loginModal").modal("show");
    }
};
mapHandler = function (userId) {
    let token = localStorage.getItem("accessToken");

    if (token) {
        location.href = window.origin + "/maps";
    } else {
        $("#loginModal").modal("show");
    }
};
blockHandler = function (userId) {
    let token = localStorage.getItem("accessToken");

    if (token) {
        let formData = new FormData();
        formData.append("block_user_id", userId);
        $.ajax({
            url: window.origin + "/api/block/store",
            type: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Authorization: token,
            },
            beforeSend: function () {
                $('#block-submit-button' + userId).prop('disabled', true);
                $('#preloader').removeClass('d-none');
            },
            success: function (res) {
                toastr.success(res.message);
                location.reload()
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                console.log(jqXhr);
            },
            complete: function (xhr, status) {

                $('#preloader').addClass('d-none');
                $('#block-submit-button' + userId).prop('disabled', false);
            }
        });
    } else {
        $("#loginModal").modal("show");
    }
};

alertHandler = function (alerted_user_id) {
    let token = localStorage.getItem("accessToken");
    if (token) {
        $('#alertModal').modal('show')
        $('#reported_user_id').val(alerted_user_id)

        // let formData = new FormData();
        // formData.append("alert_user_id", userId);
        // $.ajax({
        //     url: window.origin + "/api/alert/store",
        //     type: "POST",
        //     data: formData,
        //     dataType: "json",
        //     processData: false,
        //     contentType: false,
        //     headers: {
        //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        //         Authorization: token,
        //     },
        //     success: function (res) {
        //         toastr.success(res.message);
        //     },
        //     error: function (jqXhr, ajaxOptions, thrownError) {
        //         console.log(jqXhr);
        //     },
        // });
    } else {
        $("#loginModal").modal("show");
    }
};

/**
 * WITHOUT LOGIN ACTION
 */
authAction = function (image, flashIcon, moreIcon) {
    let token = localStorage.getItem("accessToken");
    image.forEach((item) => {
        if (token) {
            item.classList.remove("img-blur");
        }
    });

    flashIcon.forEach((item) => {

        let div = item.getAttribute("id");
        let flashId = "#" + div;
        let user_id = item.getAttribute('data-user-id')


        $(document).on("click", flashId, function () {
            if (token) {
                $('#receiver_id').val(user_id)
                $("#loginModal").modal("hide");
                $("#flashModal").modal("show");
            } else {
                $("#loginModal").modal("show");
            }
        });
    });

    moreIcon.forEach((item) => {

        let div = item.getAttribute("id");
        let moreIconId = "#" + div;

        $(document).on("click", moreIconId, function () {
            if (token) {
                moreIconId.removeAttr("data-bs-toggle");
                $("#loginModal").modal("show");
            }
        });
    });
};

closeMessenger = function () {
    $(".messenger").addClass("d-none");
};

var fromuserId = "";
var TouserId = "";

messenger = function (id, userid) {
    let token = localStorage.getItem("accessToken") || null;
    if (token) {
        $("#messenger" + userid).removeClass("d-none");

        let form = document.getElementById("messageForm" + userid);
        let input = document.getElementById("message_input" + userid);
        let to_user_id = document.getElementById(
            "messenger-to-userid" + userid
        );

        $("#messages" + userid).html("");
        fetchMSG(to_user_id.value, userid);

        let currentUser = JSON.parse(localStorage.getItem("user"));

        fromuserId = currentUser.id;
        TouserId = to_user_id.value;

        form.addEventListener("submit", function (e) {
            e.preventDefault();


            let formData = new FormData();
            formData.append("from_user_id", currentUser.id);
            formData.append("to_user_id", to_user_id.value);

            formData.append("message", input.value);





            if (input.value) {
                $.ajax({
                    url: window.origin + "/api/send-messages",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        Authorization: token,
                    },
                    beforeSend: function () {
                        $('#message-submit-button' + userid).prop('disabled', true);
                        // $('#preloader').removeClass('d-none');
                    },
                    success: function (res) {
                        input.value = "";
                    },
                    error: function (jqXhr, ajaxOptions, thrownError) {
                        console.log(jqXhr);
                    },

                    complete: function (xhr, status) {

                        // $('#preloader').addClass('d-none');
                        $('#message-submit-button' + userid).prop('disabled', false);
                    }
                });


                const options = {
                    method: "post",
                    url: "/send-message",
                    data: {
                        from_user_id: currentUser.id,
                        to_user_id: to_user_id.value,
                        message: input.value,
                    },
                };

                axios(options);
            }


        });

        window.Echo.channel("chat").listen(".message", (e) => {
            $("#messenger" + fromuserId).removeClass("d-none");
            console.log(TouserId)

            $("#messages" + e.to_user_id).append(`
                <li class="${
                e.to_user_id == TouserId ? "text-start" : "text-end"
            }">
                    <span class="${
                e.to_user_id == TouserId ? "bg-success" : "bg-warning"
            } d-inline-block rounded mb-2 p-2">
                        ${e.message}
                    </span>
                </li>
            `);

            $("#messages" + e.to_user_id).scrollTop(
                $("#messages" + e.to_user_id).height()
            );

            $("#messages" + e.from_user_id).append(`
                <li class="${
                e.from_user_id != e.to_user_id ? "text-end" : "text-start"
            }">
                    <span class="${
                e.from_user_id != e.to_user_id
                    ? "bg-warning"
                    : "bg-success"
            } d-inline-block rounded mb-2 p-2">
                        ${e.message}
                    </span>
                </li>
            `);

            $("#messages" + e.from_user_id).scrollTop(
                $("#messages" + e.from_user_id).height()
            );
        });
    } else {
        $("#loginModal").modal("show");
    }
};

function fetchMSG(to_user_id, userid) {
    $.ajax({
        url: window.origin + "/api/get-message/" + to_user_id,
        type: "GET",
        dataType: "json",
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: token,
        },
        success: function (res) {

            res.data.forEach((item) => {
                $("#messages" + userid).append(`
                    <li class="${
                    item.from_user == userid ? "text-end" : "text-start"
                }">
                        <span class="${
                    item.from_user == userid
                        ? "bg-warning"
                        : "bg-success"
                } d-inline-block rounded mb-2 p-2">
                            ${item.messages}
                        </span>
                    </li>
                `);
            });

            $("#messages" + userid).scrollTop($("#messages" + userid).height());
        },
        error: function (jqXhr, ajaxOptions, thrownError) {
            console.log(jqXhr);
        },
    });
}

//
// $(document).ready(function () {
//     let token = localStorage.getItem("accessToken");
//     $.ajax({
//         url: window.origin + "/api/get-message/all",
//         type: "GET",
//         dataType: "json",
//         processData: false,
//         contentType: false,
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//             Authorization: token,
//         },
//         success: function (res) {
//         },
//         error: function (jqXhr, ajaxOptions, thrownError) {
//             console.log(jqXhr);
//         },
//     });
// });

