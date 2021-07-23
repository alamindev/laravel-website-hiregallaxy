$(function() {
    var token = $("meta[name=csrf_token]").attr("content");
    var loader = $(".loader");
    var contents = $(".main-content");
    var posted__jobs = $("#posted__jobs");
    var live__jobs = $("#live__jobs");
    var progress__jobs = $("#progress__jobs");
    var archived__jobs = $("#archived__jobs");

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
        queryParams("?type=posted-jobs");
    }

    if (
        getQueryParams() === "posted-jobs" ||
        getQueryParams() === "live-jobs" ||
        getQueryParams() === "progress-jobs" ||
        getQueryParams() === "archived-jobs"
    ) {
        var params = getQueryParams();
        if (params === "posted-jobs") {
            contents.addClass("posted__jobs");
            contents.closest(".content__area").addClass("posted_jobs_area");
            contents.removeClass("live__jobs");
            contents.removeClass("progress__jobs");
            contents.removeClass("archived__jobs");
            posted__jobs.addClass("active");
            live__jobs.removeClass("active");
            progress__jobs.removeClass("active");
            archived__jobs.removeClass("active");
            ajax_job("posted_job");
        } else if (params === "live-jobs") {
            contents.removeClass("posted__jobs");
            contents.closest(".content__area").addClass("live__jobs_area");
            contents.addClass("live__jobs");
            contents.removeClass("progress__jobs");
            contents.removeClass("archived__jobs");
            posted__jobs.removeClass("active");
            live__jobs.addClass("active");
            progress__jobs.removeClass("active");
            archived__jobs.removeClass("active");
            ajax_job("job_status_show", "Live");
        } else if (params === "progress-jobs") {
            contents.removeClass("posted__jobs");
            contents.closest(".content__area").addClass("progress__jobs_area");
            contents.removeClass("live__jobs");
            contents.addClass("progress__jobs");
            contents.removeClass("archived__jobs");
            posted__jobs.removeClass("active");
            live__jobs.removeClass("active");
            progress__jobs.addClass("active");
            archived__jobs.removeClass("active");
            ajax_job("job_status_show", "In-progress");
        } else if (params === "archived-jobs") {
            contents.removeClass("posted__jobs");
            contents.closest(".content__area").addClass("archived__jobs_area");
            contents.removeClass("live__jobs");
            contents.removeClass("progress__jobs");
            contents.addClass("archived__jobs");
            posted__jobs.removeClass("active");
            live__jobs.removeClass("active");
            progress__jobs.removeClass("active");
            archived__jobs.addClass("active");
            ajax_job("job_status_show", "Archived");
        }
    } else {
        contents.empty();
        contents.append(
            '<div class="d-flex justify-content-center"> <p class="mt-4"><span class="alert alert-danger">404 Sorry!! Page not found !!</span></p> </div>'
        );
    }

    posted__jobs.on("click", function() {
        if (!$(this).hasClass("active")) {
            contents.empty();
            loader.empty();
            contents.addClass("posted__jobs");
            contents.closest(".content__area").addClass("posted_jobs_area");
            contents.removeClass("live__jobs");
            contents.removeClass("progress__jobs");
            contents.removeClass("archived__jobs");
            posted__jobs.addClass("active");
            live__jobs.removeClass("active");
            progress__jobs.removeClass("active");
            archived__jobs.removeClass("active");
            queryParams("?type=posted-jobs");
            ajax_job("posted_job");
        }
    });
    live__jobs.on("click", function() {
        if (!$(this).hasClass("active")) {
            contents.empty();
            loader.empty();
            contents.removeClass("posted__jobs");
            contents.closest(".content__area").addClass("live__jobs_area");
            contents.addClass("live__jobs");
            contents.removeClass("progress__jobs");
            contents.removeClass("archived__jobs");
            posted__jobs.removeClass("active");
            live__jobs.addClass("active");
            progress__jobs.removeClass("active");
            archived__jobs.removeClass("active");
            queryParams("?type=live-jobs");
            ajax_job("job_status_show", "Live");
        }
    });
    progress__jobs.on("click", function() {
        if (!$(this).hasClass("active")) {
            contents.empty();
            loader.empty();
            contents.removeClass("posted__jobs");
            contents.closest(".content__area").addClass("progress__jobs_area");
            contents.removeClass("live__jobs");
            contents.addClass("progress__jobs");
            contents.removeClass("archived__jobs");
            posted__jobs.removeClass("active");
            live__jobs.removeClass("active");
            progress__jobs.addClass("active");
            archived__jobs.removeClass("active");
            queryParams("?type=progress-jobs");
            ajax_job("job_status_show", "In-progress");
        }
    });
    archived__jobs.on("click", function() {
        if (!$(this).hasClass("archived__jobs")) {
            contents.empty();
            loader.empty();
            contents.removeClass("posted__jobs");
            contents.closest(".content__area").addClass("archived__jobs_area");
            contents.removeClass("live__jobs");
            contents.removeClass("progress__jobs");
            contents.addClass("archived__jobs");
            posted__jobs.removeClass("active");
            live__jobs.removeClass("active");
            progress__jobs.removeClass("active");
            archived__jobs.addClass("active");
            queryParams("?type=archived-jobs");
            ajax_job("job_status_show", "Archived");
        }
    });

    function ajax_job(method, status = null) {
        let id = $(".content__area").attr("data-team");
        $.ajax({
            url: ajax_url,
            beforeSend: function() {
                contents.empty();
                $(
                    '<div class="w-100 mt-lg-5 mt-2 loading"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>'
                ).appendTo(loader);
            },
            data: { action: method, status: status, id: id, _token: token },
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
                }
            },
            complete: function() {
                loader.empty();
            },
            error: function(err) {
                //Show error
                alert(err);
            }
        });
    }
});