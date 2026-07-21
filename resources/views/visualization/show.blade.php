@extends('layouts.app')

@section('title', 'Visualisasi — ' . $country->name)

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('visualization.index') }}">Visualization</a>
</li>
<li class="breadcrumb-item active">
    {{ $country->name }}
</li>
@endsection

@section('content')

<div class="card mb-4 border-0 text-white"
    style="background:linear-gradient(135deg,#1a1d23,#0d3880);">

    <div class="card-body py-3 d-flex align-items-center gap-3">

        <span style="font-size:2.7rem">
            {{ $country->flag_emoji ?? '🏳️' }}
        </span>

        <div class="flex-fill">

            <h4 class="fw-bold mb-1 text-white">
                {{ $country->name }}
            </h4>

            <small class="opacity-75">
                {{ $country->region }}
                ·
                {{ $country->subregion }}
            </small>

        </div>

        @if($riskScore)

        <div class="text-end">

            <h2 class="fw-bold mb-1"
                style="color:{{ $riskScore['marker_color'] ?? '#fff' }}">

                {{ number_format($riskScore['total_score'],1) }}

            </h2>

            <span class="badge bg-{{ $riskScore['risk_badge_class'] ?? 'secondary' }}">

                {{ $riskScore['risk_label'] ?? '-' }}

            </span>

        </div>

        @endif

    </div>

</div>


<div class="row g-4 mb-4">

    <div class="col-md-6">

        <div class="card h-100">

            <div class="card-header fw-semibold">

                GDP Trend (5 Tahun)

            </div>

            <div class="card-body">

                <canvas id="gdpC" height="220"></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card h-100">

            <div class="card-header fw-semibold">

                Inflation Trend (5 Tahun)

            </div>

            <div class="card-body">

                <canvas id="inflC" height="220"></canvas>

            </div>

        </div>

    </div>

</div>


<div class="row g-4">

    <div class="col-md-6">

        <div class="card h-100">

            <div class="card-header fw-semibold">

                Currency Trend (30 Hari)

            </div>

            <div class="card-body">

                <canvas id="currC" height="220"></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card h-100">

            <div class="card-header fw-semibold">

                Risk Trend (30 Hari)

            </div>

            <div class="card-body">

                <canvas id="riskC" height="220"></canvas>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

@php

$g = $gdpTrend ?? [];

$inf = $inflationTrend ?? [];

$rt = $riskTrend ?? [];

$currencyTrend = $currencyTrend ?? [];

$riskColors = [];

foreach(($rt['levels'] ?? []) as $level){

    switch($level){

        case 'low':
            $riskColors[]='#198754';
            break;

        case 'medium':
            $riskColors[]='#ffc107';
            break;

        case 'high':
            $riskColors[]='#dc3545';
            break;

        case 'critical':
            $riskColors[]='#212529';
            break;

        default:
            $riskColors[]='#6c757d';
    }

}

@endphp

<script>

document.addEventListener("DOMContentLoaded",function(){

@if(count($g))

new Chart(document.getElementById("gdpC"),{

    type:'bar',

    data:{

        labels:@json(array_column($g,'year')),

        datasets:[{

            data:@json(array_column($g,'value')),

            backgroundColor:'rgba(25,135,84,.75)',

            borderRadius:4

        }]

    },

    options:{

        responsive:true,

        plugins:{legend:{display:false}}

    }

});

@else

document.getElementById('gdpC').parentElement.innerHTML='<div class="text-center text-muted py-5">Data tidak tersedia</div>';

@endif



@if(count($inf))

new Chart(document.getElementById("inflC"),{

    type:'line',

    data:{

        labels:@json(array_column($inf,'year')),

        datasets:[{

            data:@json(array_column($inf,'value')),

            borderColor:'#dc3545',

            backgroundColor:'rgba(220,53,69,.15)',

            fill:true,

            tension:.4

        }]

    },

    options:{

        responsive:true,

        plugins:{legend:{display:false}}

    }

});

@else

document.getElementById('inflC').parentElement.innerHTML='<div class="text-center text-muted py-5">Data tidak tersedia</div>';

@endif



@if(isset($currencyTrend['rates']) && count($currencyTrend['rates']))

new Chart(document.getElementById("currC"),{

    type:'line',

    data:{

        labels:@json($currencyTrend['labels'] ?? []),

        datasets:[{

            data:@json($currencyTrend['rates'] ?? []),

            borderColor:'#ffc107',

            backgroundColor:'rgba(255,193,7,.15)',

            fill:true,

            tension:.4

        }]

    },

    options:{

        responsive:true,

        plugins:{legend:{display:false}}

    }

});

@else

document.getElementById('currC').parentElement.innerHTML='<div class="text-center text-muted py-5">Data kurs belum tersedia</div>';

@endif



@if(!empty($rt['labels']))

new Chart(document.getElementById("riskC"),{

    type:'line',

    data:{

        labels:@json($rt['labels']),

        datasets:[{

            data:@json($rt['data']),

            borderColor:'#0d6efd',

            backgroundColor:'rgba(13,110,253,.15)',

            fill:true,

            tension:.4,

            pointRadius:5,

            pointBackgroundColor:@json($riskColors)

        }]

    },

    options:{

        responsive:true,

        plugins:{legend:{display:false}},

        scales:{

            y:{

                min:0,

                max:100

            }

        }

    }

});

@else

document.getElementById('riskC').parentElement.innerHTML='<div class="text-center text-muted py-5">Belum ada histori risk score</div>';

@endif

});

</script>

@endpush