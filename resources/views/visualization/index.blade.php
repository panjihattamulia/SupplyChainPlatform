@extends('layouts.app')

@section('title','Data Visualization Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('dashboard') }}">Dashboard</a>
</li>

<li class="breadcrumb-item active">
    Data Visualization
</li>
@endsection

@section('content')

<div class="container-fluid">

    {{-- =========================
            HERO HEADER
    ==========================--}}

    <div class="card border-0 shadow-lg mb-4 overflow-hidden"
         style="background:linear-gradient(135deg,#0f172a,#1d4ed8);border-radius:25px;">

        <div class="card-body p-5">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <h2 class="fw-bold text-white mb-2">
                        <i class="bi bi-bar-chart-line-fill me-2"></i>
                        Global Supply Chain
                        Visualization Dashboard
                    </h2>

                    <p class="text-white opacity-75 fs-5 mb-0">
                        GDP • Inflation • Currency •
                        Exchange Rate • Risk Score •
                        Historical Trend
                    </p>

                </div>

                <div class="col-lg-4 text-end">
                    <i class="bi bi-globe2 text-white"
                       style="font-size:90px;opacity:.15;"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- =========================
            FILTER CARD
    ==========================--}}

    <div class="card border-0 shadow rounded-4 mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-5">
                    <label class="fw-semibold mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        Select Country
                    </label>

                    <select id="vizSel" class="form-select form-select-lg">
                        @foreach($countries as $c)
                        <option value="{{ $c->code }}">
                            {{ $c->flag_emoji }} {{ $c->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mt-4">
                    <button class="btn btn-primary btn-lg w-100" onclick="loadViz()">
                        <i class="bi bi-search me-1"></i>
                        Show
                    </button>
                </div>

                <div class="col-md-5">
                    <label class="fw-semibold mb-2">Quick Country</label>

                    <div class="d-flex flex-wrap gap-2">
                        @foreach($countries->take(8) as $c)
                        <button class="btn btn-outline-secondary btn-sm rounded-pill"
                                onclick="qViz('{{ $c->code }}')">
                            {{ $c->flag_emoji }} {{ $c->code }}
                        </button>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

    </div>

    {{-- =========================
            STATISTIC CARD
    ==========================--}}

    <div class="row mb-4">

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow rounded-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">GDP</small>
                            <h3 id="gdpValue" class="fw-bold text-success mt-2">-</h3>
                        </div>
                        <div>
                            <i class="bi bi-bank2 text-success" style="font-size:42px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow rounded-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">Inflation</small>
                            <h3 id="inflValue" class="fw-bold text-danger mt-2">-</h3>
                        </div>
                        <div>
                            <i class="bi bi-graph-down-arrow text-danger" style="font-size:42px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow rounded-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">Exchange Rate</small>
                            <h3 id="currValue" class="fw-bold text-warning mt-2">-</h3>
                        </div>
                        <div>
                            <i class="bi bi-currency-exchange text-warning" style="font-size:42px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow rounded-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">Risk Score</small>
                            <h3 id="riskValue" class="fw-bold text-primary mt-2">-</h3>
                        </div>
                        <div>
                            <i class="bi bi-shield-check text-primary" style="font-size:42px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- =========================
            COUNTRY BANNER
    ==========================--}}

    <div id="vizBanner" class="card border-0 shadow-lg mb-4"
         style="display:none;border-radius:25px;background:linear-gradient(135deg,#2563eb,#1e3a8a);">

        <div class="card-body p-4">
            <div class="row align-items-center">

                <div class="col-auto">
                    <div style="width:90px;height:90px;border-radius:50%;background:rgba(255,255,255,.15);
                                display:flex;align-items:center;justify-content:center;font-size:50px;">
                        <span id="vFlag"></span>
                    </div>
                </div>

                <div class="col">
                    <h2 id="vName" class="text-white fw-bold mb-1"></h2>
                    <p class="text-light mb-0">Global Supply Chain Monitoring</p>
                </div>

                <div class="col-auto">
                    <span id="vRisk" class="badge fs-5 px-4 py-3 rounded-pill"></span>
                </div>

            </div>
        </div>

    </div>

    {{-- =========================
            PLACEHOLDER
    ==========================--}}

    <div id="vizPH" class="card border-0 shadow rounded-4">
        <div class="card-body text-center py-5">
            <i class="bi bi-bar-chart display-1 text-primary opacity-25"></i>
            <h4 class="mt-3">Select Country</h4>
            <p class="text-muted">Please choose a country to display visualization dashboard.</p>
        </div>
    </div>

    {{-- =========================
            CHART CONTAINER
    ==========================--}}

    <div id="vizCharts" style="display:none;">

        <!-- CHART ROW 1 -->
        <div class="row g-4 mb-4">

            <div class="col-lg-6">
                <div class="card chart-card border-0 shadow-lg h-100">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-bar-chart-fill text-success me-2"></i>
                            GDP Trend
                        </h5>
                        <small class="text-muted">Last 5 Years</small>
                    </div>
                    <div class="card-body">
                        <canvas id="vGdp" height="220"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card chart-card border-0 shadow-lg h-100">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-graph-down-arrow text-danger me-2"></i>
                            Inflation Trend
                        </h5>
                        <small class="text-muted">Annual Inflation</small>
                    </div>
                    <div class="card-body">
                        <canvas id="vInfl" height="220"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <!-- CHART ROW 2 -->
        <div class="row g-4">

            <div class="col-lg-6">
                <div class="card chart-card border-0 shadow-lg h-100">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-currency-exchange text-warning me-2"></i>
                            Exchange Rate
                        </h5>
                        <small class="text-muted">Last 30 Days</small>
                    </div>
                    <div class="card-body">
                        <canvas id="vCurr" height="220"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card chart-card border-0 shadow-lg h-100">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-shield-fill-exclamation text-primary me-2"></i>
                            Supply Chain Risk
                        </h5>
                        <small class="text-muted">Risk History</small>
                    </div>
                    <div class="card-body">
                        <canvas id="vRiskChart" height="220"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- Loading overlay (dipakai oleh showSpinner()/hideSpinner()) --}}
    <div id="loadingOverlay"
         style="display:none;position:fixed;inset:0;background:rgba(255,255,255,.6);
                z-index:2000;align-items:center;justify-content:center;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

</div>

@endsection


@push('styles')
<style>
body{ background:#f5f7fb; }

.card{ border-radius:22px; transition:.35s; }

.chart-card:hover{
    transform:translateY(-8px);
    box-shadow:0 18px 40px rgba(0,0,0,.12)!important;
}

.card-header{
    background:white!important;
    border-bottom:1px solid #eef2f7!important;
}

.btn{ border-radius:12px; }

.btn-primary{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    border:none;
}

.btn-primary:hover{
    background:linear-gradient(135deg,#1d4ed8,#1e40af);
}

.form-select{ border-radius:12px; padding:12px; }

h3{ letter-spacing:.5px; }

#vizBanner{
    overflow:hidden;
    box-shadow:0 18px 45px rgba(37,99,235,.35);
    position:relative;
}

#vizBanner::before{
    content:"";
    position:absolute;
    top:-80px;
    right:-60px;
    width:220px;
    height:220px;
    border-radius:50%;
    background:rgba(255,255,255,.08);
}

#vizBanner::after{
    content:"";
    position:absolute;
    bottom:-120px;
    left:-80px;
    width:240px;
    height:240px;
    border-radius:50%;
    background:rgba(255,255,255,.06);
}

canvas{ width:100%!important; max-height:320px; }

#vizPH{ border-radius:22px; }

@media(max-width:992px){
    .display-1{ font-size:4rem; }
    .card-body{ padding:1.3rem; }
}

@media(max-width:768px){
    #vizBanner .row{ text-align:center; }
    #vizBanner .col-auto{ margin:auto; }
}
</style>
@endpush


@push('scripts')
<script>
/* ==========================================
        STATE (chart instances)
========================================== */
let cG = null;
let cI = null;
let cC = null;
let cR = null;

/* ==========================================
        LOADING OVERLAY
   (didefinisikan di top-level supaya bisa
    dipanggil dari fungsi manapun)
========================================== */
function showSpinner(){
    const loader = document.getElementById("loadingOverlay");
    if(loader){
        loader.style.display = "flex";
    }
}

function hideSpinner(){
    const loader = document.getElementById("loadingOverlay");
    if(loader){
        loader.style.display = "none";
    }
}

/* ==========================================
        GDP CHART
========================================== */
function buildG(data){

    if(cG){
        cG.destroy();
        cG = null;
    }

    const canvas = document.getElementById("vGdp");
    const parent = canvas.parentElement;
    parent.innerHTML = '<canvas id="vGdp" height="220"></canvas>';
    const ctx = document.getElementById("vGdp").getContext("2d");

    if(!data || !data.length){
        parent.innerHTML =
            '<div class="text-center py-5 text-muted">' +
            '<i class="bi bi-bar-chart display-5"></i>' +
            '<p class="mt-3 mb-0">GDP data not available</p>' +
            '</div>';
        return;
    }

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, "rgba(25,135,84,.90)");
    gradient.addColorStop(.5, "rgba(25,135,84,.55)");
    gradient.addColorStop(1, "rgba(25,135,84,.20)");

    cG = new Chart(ctx, {
        type: "bar",
        data: {
            labels: data.map(e => e.year),
            datasets: [{
                label: "GDP",
                data: data.map(e => e.value),
                backgroundColor: gradient,
                borderRadius: 10,
                borderSkipped: false,
                maxBarThickness: 45
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200, easing: "easeOutQuart" },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "#111827",
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context){
                            let val = context.parsed.y;
                            if(val >= 1000000000000){
                                return "$" + (val / 1000000000000).toFixed(2) + " T";
                            }
                            if(val >= 1000000000){
                                return "$" + (val / 1000000000).toFixed(2) + " B";
                            }
                            return "$" + val;
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(v){
                            if(v >= 1000000000000){
                                return (v / 1000000000000).toFixed(1) + "T";
                            }
                            if(v >= 1000000000){
                                return (v / 1000000000).toFixed(1) + "B";
                            }
                            return v;
                        }
                    }
                }
            }
        }
    });
}

/* ==========================================
        INFLATION CHART
========================================== */
function buildI(data){

    if(cI){
        cI.destroy();
        cI = null;
    }

    const canvas = document.getElementById("vInfl");
    const parent = canvas.parentElement;
    parent.innerHTML = '<canvas id="vInfl" height="220"></canvas>';
    const ctx = document.getElementById("vInfl").getContext("2d");

    if(!data || !data.length){
        parent.innerHTML =
            '<div class="text-center py-5 text-muted">' +
            '<i class="bi bi-graph-down-arrow display-5"></i>' +
            '<p class="mt-3 mb-0">Inflation data not available</p>' +
            '</div>';
        return;
    }

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, "rgba(220,53,69,.35)");
    gradient.addColorStop(1, "rgba(220,53,69,0)");

    cI = new Chart(ctx, {
        type: "line",
        data: {
            labels: data.map(e => e.year),
            datasets: [{
                label: "Inflation",
                data: data.map(e => e.value),
                borderColor: "#dc3545",
                backgroundColor: gradient,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointBackgroundColor: "#dc3545",
                borderWidth: 4,
                tension: .45
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200, easing: "easeOutQuart" },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "#111827",
                    cornerRadius: 10,
                    padding: 12,
                    callbacks: {
                        label: function(context){
                            return context.parsed.y + " %";
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(v){ return v + "%"; }
                    }
                }
            }
        }
    });
}

/* ==========================================
        CURRENCY CHART
========================================== */
function buildC(data){

    if(cC){
        cC.destroy();
        cC = null;
    }

    const canvas = document.getElementById("vCurr");
    const parent = canvas.parentElement;
    parent.innerHTML = '<canvas id="vCurr" height="220"></canvas>';
    const ctx = document.getElementById("vCurr").getContext("2d");

    if(!data || !data.rates || !data.rates.length){
        parent.innerHTML =
            '<div class="text-center py-5 text-muted">' +
            '<i class="bi bi-currency-exchange display-5"></i>' +
            '<p class="mt-3 mb-0">Exchange rate data not available</p>' +
            '</div>';
        return;
    }

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, "rgba(255,193,7,.35)");
    gradient.addColorStop(1, "rgba(255,193,7,0)");

    cC = new Chart(ctx, {
        type: "line",
        data: {
            labels: data.labels,
            datasets: [{
                label: "Exchange Rate",
                data: data.rates,
                borderColor: "#ffc107",
                backgroundColor: gradient,
                fill: true,
                borderWidth: 4,
                pointRadius: 0,
                tension: .45
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200, easing: "easeOutQuart" },
            plugins: {
                legend: { display: false },
                tooltip: { backgroundColor: "#111827", cornerRadius: 10, padding: 12 }
            },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: false }
            }
        }
    });
}

/* ==========================================
        RISK CHART
========================================== */
function buildR(data){

    if(cR){
        cR.destroy();
        cR = null;
    }

    const canvas = document.getElementById("vRiskChart");
    const parent = canvas.parentElement;
    parent.innerHTML = '<canvas id="vRiskChart" height="220"></canvas>';
    const ctx = document.getElementById("vRiskChart").getContext("2d");

    if(!data || !data.labels || !data.labels.length){
        parent.innerHTML =
            '<div class="text-center py-5 text-muted">' +
            '<i class="bi bi-shield-exclamation display-5"></i>' +
            '<p class="mt-3 mb-0">Risk history not available</p>' +
            '</div>';
        return;
    }

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, "rgba(13,110,253,.35)");
    gradient.addColorStop(1, "rgba(13,110,253,0)");

    cR = new Chart(ctx, {
        type: "line",
        data: {
            labels: data.labels,
            datasets: [{
                label: "Risk Score",
                data: data.data,
                borderColor: "#0d6efd",
                backgroundColor: gradient,
                fill: true,
                borderWidth: 4,
                pointRadius: 5,
                pointHoverRadius: 8,
                tension: .45
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200, easing: "easeOutQuart" },
            plugins: {
                legend: { display: false },
                tooltip: { backgroundColor: "#111827", cornerRadius: 10, padding: 12 }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    min: 0,
                    max: 100,
                    ticks: { callback: function(v){ return v; } }
                }
            }
        }
    });
}

/* ==========================================
        QUICK COUNTRY BUTTON
========================================== */
function qViz(code){
    document.getElementById("vizSel").value = code;
    loadViz();
}

/* ==========================================
        LOAD DATA (main handler)
========================================== */
function loadViz(){

    const code = document.getElementById("vizSel").value;
    if(!code) return;

    showSpinner();

    fetch("/visualization/" + code, {
        headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(res => {
        if(!res.ok){
            throw new Error("Network Error");
        }
        return res.json();
    })
    .then(data => {

        hideSpinner();

        document.getElementById("vizPH").style.display = "none";
        document.getElementById("vizCharts").style.display = "";

        const rs = data.riskScore || {};

        /* COUNTRY BANNER */
        document.getElementById("vizBanner").style.display = "";
        document.getElementById("vFlag").innerHTML = rs.flag_emoji || "🏳️";
        document.getElementById("vName").innerHTML = rs.country_name || code;

        const badge = document.getElementById("vRisk");
        badge.innerHTML =
            (rs.risk_label || "Unknown") + " : " +
            Number(rs.total_score || 0).toFixed(1);
        badge.className =
            "badge fs-5 px-4 py-3 rounded-pill bg-" +
            (rs.risk_badge_class || "secondary");

        /* SUMMARY CARDS */
        if(data.gdpTrend && data.gdpTrend.length){
            const last = data.gdpTrend[data.gdpTrend.length - 1];
            document.getElementById("gdpValue").innerHTML =
                "$" + (last.value / 1000000000).toFixed(1) + "B";
        }else{
            document.getElementById("gdpValue").innerHTML = "-";
        }

        if(data.inflationTrend && data.inflationTrend.length){
            const last = data.inflationTrend[data.inflationTrend.length - 1];
            document.getElementById("inflValue").innerHTML = last.value + "%";
        }else{
            document.getElementById("inflValue").innerHTML = "-";
        }

        if(data.currencyTrend && data.currencyTrend.rates && data.currencyTrend.rates.length){
            document.getElementById("currValue").innerHTML =
                data.currencyTrend.rates[data.currencyTrend.rates.length - 1];
        }else{
            document.getElementById("currValue").innerHTML = "-";
        }

        document.getElementById("riskValue").innerHTML =
            Number(rs.total_score || 0).toFixed(1);

        /* BUILD CHARTS */
        buildG(data.gdpTrend || []);
        buildI(data.inflationTrend || []);
        buildC(data.currencyTrend || {});
        buildR(data.riskTrend || {});

    })
    .catch(err => {
        console.error(err);
        hideSpinner();
        alert("Failed loading visualization.");
    });
}

/* ==========================================
        PAGE LOAD
========================================== */
document.addEventListener("DOMContentLoaded", function(){
    const sel = document.getElementById("vizSel");
    if(sel && sel.options.length){
        loadViz();
    }
});
</script>
@endpush