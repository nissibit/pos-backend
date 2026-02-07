<script>
    const request = (url, params = {}, json = true, method = 'GET') => {
        let options = {
            method
        };
        if ('GET' === method) {
            url += '?' + (new URLSearchParams(params)).toString();
        } else {
            options.body = JSON.stringify(params);
        }

        return json ? (fetch(url, options).then(response => response.json())) : fetch(url, options).then(response =>
            response.text());
    };
    const get = (url, params, json) => request(url, params, json, 'GET');
    const post = (url, params, json) => request(url, params, json, 'POST');
    const carregando = '<i class="fa-solid fa-spinner fa-spin fa-spin-pulse  w3-center"></i>';
    const _loading =
        '<div class="w3-center"><i class="fas fa-spinner fa-spin fa-spin-pulse"></i></div>';

    function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
    }

    function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
    }

    function accordion(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }

    function toggleTab(evt, tabName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("tab");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" w3-theme-l4", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " w3-theme-l4";
    }

    function buildAlert(type, message) {
        let color = "";
        let icon = "";
        switch (type) {
            case "success":
                color = "green";
                icon = "check-circle";
                break;
            case "error":
                color = "red";
                icon = "times-circle";
                break;
            case "warning":
                color = "orange";
                icon = "exclamation-triangle";
                break;
            default:
                color = "blue";
                icon = "info-circle";
                break;
        }
        return `<div class='w3-grid w3-round-large w3-border w3-card-2 w3-section w3-padding w3-border-${color} w3-rightbar' style="grid-template-columns:50px auto; font-size:1.2rem"><div><i class='fas fa-${icon} fa-2x w3-text-${color}' ></i></div><div>${message}</div></div>`
    }

    function openTab(evt, tabName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("tab");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" w3-teal", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " w3-teal";
    }

    function toggleModal(modal, action) {
        let element = document.getElementById(modal);
        if (action) {
            element.classList.remove('w3-hide')
            element.classList.add('w3-show')
        } else {
            element.classList.remove('w3-show')
            element.classList.add('w3-hide')
        }
    }

    function toggleCheckBySource(source, classObjects) {
        let checked = source.checked;
        let objs = document.querySelectorAll("." + classObjects);
        objs.forEach((el) => {
            el.checked = checked;
        });
    }
    /**@argument
     *  Carregar páginas de forma assincróna.
     */
    function loadingPage(url, place, params = {}, callAfter) {
        try {
            let _container = document.querySelector("#" + place);
            _container.innerHTML = _loading;
            url += '?' + (new URLSearchParams(params)).toString();
            fetch(url)
                .then(res => res.text())
                .then(resp => {
                    _container.innerHTML = resp;
                    if (undefined !== callAfter) {
                        callAfter();
                    }
                }).catch(error => {
                    _container.innerHTML = buildAlert('error', error.message)
                })
        } catch (error) {
            _container.innerHTML = buildAlert('error', error.message)
        }
    }
</script>
<!-- <script src="{{ asset('/public/js/app.js') }}"></script> -->
@stack('scripts')