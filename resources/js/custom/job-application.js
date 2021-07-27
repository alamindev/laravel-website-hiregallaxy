$(function() {
    var token = $("meta[name=csrf_token]").attr("content");
    var loader = $(".loader");
    var contents = $(".main-content");
    var all_activity = $("#all_activity");
    var new_activity = $("#new_activity");
    var short_listed_activity = $("#short_listed_activity");
    var interview_activity = $("#interview_activity");
    var offered_activity = $("#offered_activity");
    var hired_activity = $("#hired_activity");
    var rejected_activity = $("#rejected_activity");

    function queryParams(query) {
        var newurl =
            window.location.protocol +
            "//" +
            window.location.host +
            window.location.pathname +
            query;
        return window.history.pushState({ path: newurl }, "", newurl);
    }

    function getQueryParams() {
        var queries = {};
        $.each(document.location.search.substr(1).split("&"), function(c, q) {
            var i = q.split("=");
            queries[i[0].toString()] = i[1].toString();
        });
        return queries.type;
    }

    if (!location.search) {
        queryParams("?type=all");
    }

    if (
        getQueryParams() === "all" ||
        getQueryParams() === "new" ||
        getQueryParams() === "shortlisted" ||
        getQueryParams() === "interview" ||
        getQueryParams() === "offered" ||
        getQueryParams() === "hired" ||
        getQueryParams() === "rejected"
    ) {
        var params = getQueryParams();
        if (params === "all") {
            contents.addClass("all_activity");
            contents.closest(".content__area").addClass("all");
            contents.removeClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.addClass("active");
            new_activity.removeClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.removeClass("active");
            offered_activity.removeClass("active");
            hired_activity.removeClass("active");
            rejected_activity.removeClass("active");
            ajax_job("all_activity");
        } else if (params === "new") {
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("new");
            contents.addClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.addClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.removeClass("active");
            offered_activity.removeClass("active");
            hired_activity.removeClass("active");
            rejected_activity.removeClass("active");
            ajax_job("job_activity", "New");
        } else if (params === "shortlisted") {
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("shortlisted");
            contents.removeClass("new_activity");
            contents.addClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.removeClass("active");
            short_listed_activity.addClass("active");
            interview_activity.removeClass("active");
            offered_activity.removeClass("active");
            hired_activity.removeClass("active");
            rejected_activity.removeClass("active");
            ajax_job("job_activity", "Shortlisted");
        } else if (params === "interview") {
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("interview");
            contents.removeClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.addClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.removeClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.addClass("active");
            offered_activity.removeClass("active");
            hired_activity.removeClass("active");
            rejected_activity.removeClass("active");
            ajax_job("job_activity", "Interview");
        } else if (params === "offered") {
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("offered");
            contents.removeClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.addClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.removeClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.removeClass("active");
            offered_activity.addClass("active");
            hired_activity.removeClass("active");
            rejected_activity.removeClass("active");
            ajax_job("job_activity", "Offered");
        } else if (params === "hired") {
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("hired");
            contents.removeClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.addClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.removeClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.removeClass("active");
            offered_activity.removeClass("active");
            hired_activity.addClass("active");
            rejected_activity.removeClass("active");
            ajax_job("job_activity", "Hired");
        } else if (params === "rejected") {
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("rejected");
            contents.removeClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.addClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.removeClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.removeClass("active");
            offered_activity.removeClass("active");
            hired_activity.removeClass("active");
            rejected_activity.addClass("active");
            ajax_job("job_activity", "Rejected");
        }
    } else {
        contents.empty();
        contents.append(
            '<div class="d-flex justify-content-center"> <p class="mt-4"><span class="alert alert-danger">404 Sorry!! Page not found !!</span></p> </div>'
        );
    }

    all_activity.on("click", function() {
        if (!$(this).hasClass("active")) {
            contents.empty();
            loader.empty();
            contents.addClass("all_activity");
            contents.closest(".content__area").addClass("all");
            contents.removeClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.addClass("active");
            new_activity.removeClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.removeClass("active");
            offered_activity.removeClass("active");
            hired_activity.removeClass("active");
            rejected_activity.removeClass("active");
            queryParams("?type=all");
            ajax_job("all_activity");
        }
    });
    new_activity.on("click", function() {
        if (!$(this).hasClass("active")) {
            contents.empty();
            loader.empty();
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("new");
            contents.addClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.addClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.removeClass("active");
            offered_activity.removeClass("active");
            hired_activity.removeClass("active");
            rejected_activity.removeClass("active");
            queryParams("?type=new");
            ajax_job("job_activity", "New");
        }
    });
    short_listed_activity.on("click", function() {
        if (!$(this).hasClass("active")) {
            contents.empty();
            loader.empty();
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("shortlisted");
            contents.removeClass("new_activity");
            contents.addClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.removeClass("active");
            short_listed_activity.addClass("active");
            interview_activity.removeClass("active");
            offered_activity.removeClass("active");
            hired_activity.removeClass("active");
            rejected_activity.removeClass("active");
            queryParams("?type=shortlisted");
            ajax_job("job_activity", "Shortlisted");
        }
    });
    interview_activity.on("click", function() {
        if (!$(this).hasClass("archived__jobs")) {
            contents.empty();
            loader.empty();
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("interview");
            contents.removeClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.addClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.removeClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.addClass("active");
            offered_activity.removeClass("active");
            hired_activity.removeClass("active");
            rejected_activity.removeClass("active");
            queryParams("?type=interview");
            ajax_job("job_activity", "Interview");
        }
    });
    offered_activity.on("click", function() {
        if (!$(this).hasClass("archived__jobs")) {
            contents.empty();
            loader.empty();
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("offered");
            contents.removeClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.addClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.removeClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.removeClass("active");
            offered_activity.addClass("active");
            hired_activity.removeClass("active");
            rejected_activity.removeClass("active");
            ajax_job("job_activity", "Offered");
            queryParams("?type=offered");
        }
    });
    hired_activity.on("click", function() {
        if (!$(this).hasClass("archived__jobs")) {
            contents.empty();
            loader.empty();
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("hired");
            contents.removeClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.addClass("hired_activity");
            contents.removeClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.removeClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.removeClass("active");
            offered_activity.removeClass("active");
            hired_activity.addClass("active");
            rejected_activity.removeClass("active");
            queryParams("?type=hired");
            ajax_job("job_activity", "Hired");
        }
    });

    rejected_activity.on("click", function() {
        if (!$(this).hasClass("archived__jobs")) {
            contents.empty();
            loader.empty();
            contents.removeClass("all_activity");
            contents.closest(".content__area").addClass("rejected");
            contents.removeClass("new_activity");
            contents.removeClass("short_listed_activity");
            contents.removeClass("interview_activity");
            contents.removeClass("offered_activity");
            contents.removeClass("hired_activity");
            contents.addClass("rejected_activity");
            all_activity.removeClass("active");
            new_activity.removeClass("active");
            short_listed_activity.removeClass("active");
            interview_activity.removeClass("active");
            offered_activity.removeClass("active");
            hired_activity.removeClass("active");
            rejected_activity.addClass("active");
            queryParams("?type=rejected");
            ajax_job("job_activity", "Rejected");
        }
    });

    function ajax_job(method, status = null) {
        let slug = $(".content__area").attr("data-slug");
        let id = $(".content__area").attr("data-team");
        $.ajax({
            url: ajax_url,
            beforeSend: function() {
                contents.empty();
                $(
                    '<div class="w-100 mt-lg-5 mt-2 loading"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>'
                ).appendTo(loader);
            },
            data: {
                action: method,
                status: status,
                slug: slug,
                id: id,
                _token: token
            },
            dataType: "JSON",
            type: "POST",
            success: function(res) {
                if (res.status === "success") {
                    contents.append(res.html);
                    $("#dataTable").dataTable({
                        aoColumnDefs: [{
                            bSortable: false,
                            aTargets: ["sortoff"]
                        }]
                    });

                    $('.assin_modal').click(function(){
                        $('#assign').modal('show');
                        let id = $(this).attr('data-id');
                        $('#get_link').attr('data-id',id);
                        $('#get_link').show();
                        $('.show-href').removeClass('active-href')
                    })

                    $('#get_link').click(function(){
                        $(this).hide();
                        let id = $(this).data('id');
                        let href = `https://joblrs.com/exam/home/${id}`;
                        $('.custom-link').text(href);
                        $('.show-href').addClass('active-href')
                    })

                    const copyText = document.querySelector('.copy-btn');

                        copyText.addEventListener('click', () => {
                            const link =  document.querySelector('.custom-link')
                            const selection = window.getSelection();
                            const range = document.createRange();
                            range.selectNodeContents(link);
                            selection.removeAllRanges();
                            selection.addRange(range);

                            try {
                                document.execCommand('copy');
                                selection.removeAllRanges();

                                const mailId = link.textContent;
                                link.textContent = 'Copied!';
                                link.classList.add('text-success');

                                setTimeout(() => {
                                    link.textContent = mailId;
                                    link.classList.remove('text-success');
                                }, 1000);
                            } catch (e) {
                                link.textContent = 'Couldn\'t copy, hit Ctrl+C!';
                                link.classList.add('error');

                                setTimeout(() => {
                                    errorMsg.classList.remove('show');
                                }, 1200);
                            }
                        });
                }
            },
            complete: function() {
                loader.empty();
            }
        });
    }
});
