@extends('layouts.app')
@section('title', $country->name)
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('countries.index') }}">Countries</a></li>
<li class="breadcrumb-item active">{{ $country->name }}</li>
@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#0A1E2E; --surface:#102A3D; --surface-raised:#16374C; --line:#20415A;
  --text:#EAF2F6; --text-dim:#7FA0B8;
  --cyan:#3FD0C9; --amber:#F0A947; --gold:#F0B84B; --coral:#EF5B5B; --coral-deep:#C23A3A;
}
.cd-wrap{ font-family:'Inter',sans-serif; color:var(--text); }

/* Hero */
.cd-hero{
  position:relative; overflow:hidden; background:radial-gradient(circle at 15% 10%,#153a52 0%,var(--ink) 65%);
  border:1px solid var(--line); border-radius:20px; padding:2rem 1.75rem; margin-bottom:1.5rem;
}
.cd-hero-flag{ font-size:4.5rem; line-height:1; filter:drop-shadow(0 10px 20px rgba(0,0,0,.4)); }
.cd-hero-eyebrow{ font-family:'IBM Plex Mono',monospace; font-size:.66rem; letter-spacing:.16em; text-transform:uppercase; color:var(--cyan); display:flex; align-items:center; gap:.5rem; margin-bottom:.4rem; }
.cd-hero-eyebrow::before{ content:''; width:6px; height:6px; border-radius:50%; background:var(--cyan); box-shadow:0 0 0 3px rgba(63,208,201,.25); }
.cd-hero-name{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:2.1rem; margin:0; color:var(--text); }
.cd-hero-meta{ font-family:'IBM Plex Mono',monospace; font-size:.78rem; color:var(--text-dim); margin-top:.25rem; }
.cd-hero-currency{ font-size:.8rem; color:var(--text-dim); margin-top:.35rem; }
.cd-hero-currency i{ color:var(--gold); }

.cd-hero-score-label{ font-family:'IBM Plex Mono',monospace; font-size:.65rem; letter-spacing:.1em; text-transform:uppercase; color:var(--text-dim); text-align:right; }
.cd-hero-score{ font-family:'IBM Plex Mono',monospace; font-weight:700; font-size:3rem; line-height:1; text-align:right; }
.cd-hero-badge{ font-family:'IBM Plex Mono',monospace; font-size:.72rem; padding:.3rem .7rem; border-radius:20px; border:1px solid; float:right; margin-top:.3rem; }

/* Panels */
.cd-panel{ background:var(--surface); border:1px solid var(--line); border-radius:18px; overflow:hidden; margin-bottom:1.25rem; }
.cd-panel-head{ font-family:'IBM Plex Mono',monospace; font-size:.72rem; letter-spacing:.08em; text-transform:uppercase; color:var(--text-dim); padding:.9rem 1.1rem; border-bottom:1px solid var(--line); display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }
.cd-panel-head i{ color:var(--cyan); }
.cd-panel-head small{ font-family:'Inter',sans-serif; font-size:.72rem; text-transform:none; letter-spacing:0; color:var(--text-dim); font-weight:400; }
.cd-panel-body{ padding:1.1rem; }

/* Risk breakdown */
.cd-risk-grid{ display:grid; grid-template-columns:repeat(4,1fr); gap:.7rem; margin-bottom:1.1rem; }
.cd-risk-item{ background:var(--ink); border:1px solid var(--line); border-radius:12px; padding:.9rem .5rem; text-align:center; }
.cd-risk-item i{ font-size:1.3rem; }
.cd-risk-value{ font-family:'IBM Plex Mono',monospace; font-weight:700; font-size:1.4rem; margin-top:.4rem; }
.cd-risk-label{ font-family:'IBM Plex Mono',monospace; font-size:.62rem; letter-spacing:.06em; text-transform:uppercase; color:var(--text-dim); margin-top:.15rem; }
.cd-progress-track{ height:14px; background:var(--ink); border-radius:20px; overflow:hidden; border:1px solid var(--line); }
.cd-progress-fill{ height:100%; border-radius:20px; transition:width .8s ease; }
.cd-progress-scale{ display:flex; justify-content:space-between; font-family:'IBM Plex Mono',monospace; font-size:.62rem; color:var(--text-dim); margin-top:.35rem; }

/* Economic */
.cd-econ-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:.7rem; }
.cd-econ-item{ background:var(--ink); border:1px solid var(--line); border-radius:12px; padding:.9rem .5rem; text-align:center; }
.cd-econ-label{ font-family:'IBM Plex Mono',monospace; font-size:.62rem; letter-spacing:.06em; text-transform:uppercase; color:var(--text-dim); }
.cd-econ-value{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:1.2rem; margin-top:.3rem; }
.cd-empty{ text-align:center; color:var(--text-dim); padding:2rem 1rem; }
.cd-empty i{ font-size:2rem; opacity:.3; display:block; margin-bottom:.5rem; }

/* Weather side card */
.cd-weather-card{
  background:radial-gradient(circle at 20% 0%,#153a52 0%,var(--ink) 65%); border:1px solid var(--line);
  border-radius:16px; padding:1.3rem; text-align:center; margin-bottom:1.25rem;
}
.cd-weather-eyebrow{ font-family:'IBM Plex Mono',monospace; font-size:.62rem; letter-spacing:.1em; text-transform:uppercase; color:var(--text-dim); margin-bottom:.6rem; }
.cd-weather-icon{ font-size:2.8rem; line-height:1; }
.cd-weather-temp{ font-family:'IBM Plex Mono',monospace; font-weight:700; font-size:2.2rem; }
.cd-weather-desc{ font-size:.8rem; color:var(--text-dim); margin-bottom:.6rem; }
.cd-weather-strip{ display:flex; justify-content:space-around; margin-top:.5rem; }
.cd-weather-strip-label{ font-family:'IBM Plex Mono',monospace; font-size:.6rem; color:var(--text-dim); }
.cd-weather-strip-value{ font-family:'IBM Plex Mono',monospace; font-size:.82rem; font-weight:600; }
.cd-weather-flags{ display:flex; flex-wrap:wrap; gap:.35rem; justify-content:center; margin-top:.7rem; }
.cd-weather-flag{ font-family:'IBM Plex Mono',monospace; font-size:.6rem; padding:.25rem .5rem; border-radius:16px; border:1px solid; }
.cd-weather-risk{ margin-top:.8rem; padding:.5rem; background:rgba(63,208,201,.08); border:1px solid rgba(63,208,201,.3); border-radius:10px; font-family:'IBM Plex Mono',monospace; font-size:.72rem; color:var(--cyan); }

/* Actions */
.cd-action-btn{
  display:flex; align-items:center; gap:.55rem; width:100%; background:transparent; border:1px solid var(--line);
  color:var(--text); font-family:'Inter',sans-serif; font-weight:500; font-size:.83rem; border-radius:10px;
  padding:.6rem .8rem; text-decoration:none; transition:border-color .15s, background .15s, color .15s;
}
.cd-action-btn i{ width:16px; }
.cd-action-btn:hover{ border-color:var(--cyan); background:rgba(63,208,201,.06); color:var(--cyan); }
.cd-action-btn--wl{ border-color:var(--gold-dim,#C99A3E); color:var(--gold); }
.cd-action-btn--wl.is-active{ background:rgba(240,184,75,.12); }
.cd-action-btn--wl:hover{ border-color:var(--gold); background:rgba(240,184,75,.1); color:var(--gold); }

/* Info table */
.cd-info-row{ display:flex; justify-content:space-between; padding:.55rem 0; border-bottom:1px solid var(--line); font-size:.83rem; }
.cd-info-row:last-child{ border-bottom:none; }
.cd-info-label{ color:var(--text-dim); font-family:'IBM Plex Mono',monospace; font-size:.7rem; text-transform:uppercase; letter-spacing:.05em; }
.cd-info-value{ font-weight:500; color:var(--text); text-align:right; }

.cd-toast{
  position:fixed; bottom:1rem; right:1rem; z-index:9999; background:var(--surface-raised); border:1px solid var(--line);
  color:var(--text); font-family:'Inter',sans-serif; font-size:.85rem; padding:.7rem 1.1rem; border-radius:10px;
  box-shadow:0 10px 30px -10px rgba(0,0,0,.5);
}
.cd-toast--success{ border-color:var(--cyan); color:var(--cyan); }
.cd-toast--danger{ border-color:var(--coral); color:var(--coral); }

@media (max-width:767px){
  .cd-risk-grid{ grid-template-columns:repeat(2,1fr); }
  .cd-econ-grid{ grid-template-columns:repeat(2,1fr); }
  .cd-hero-score, .cd-hero-score-label, .cd-hero-badge{ text-align:left; float:none; }
}
</style>
@endpush

@section('content')
<div class="cd-wrap">

<div class="cd-hero">
  <div class="row align-items-center g-3">
    <div class="col-auto"><div class="cd-hero-flag">{{ $country->flag_emoji??'🏳️' }}</div></div>
    <div class="col">
      <div class="cd-hero-eyebrow">Country Dossier</div>
      <h1 class="cd-hero-name">{{ $country->name }}</h1>
      <div class="cd-hero-meta">{{ $country->capital }} · {{ $country->region }} · {{ $country->subregion }}</div>
      @if($country->currency_code)
      <div class="cd-hero-currency">
        <i class="bi bi-currency-exchange me-1"></i>{{ $country->currency_code }} — {{ $country->currency_name }}
        @if($currencyRate) &nbsp;|&nbsp; 1 USD = {{ number_format($currencyRate,2) }} {{ $country->currency_code }} @endif
      </div>
      @endif
    </div>
    @if(isset($riskScore['total_score']))
    @php
      $rl = $riskScore['risk_label'] ?? '';
      $rColor = $riskScore['marker_color'] ?? '#7FA0B8';
    @endphp
    <div class="col-auto">
      <div class="cd-hero-score-label">Risk Score</div>
      <div class="cd-hero-score" style="color:{{ $rColor }}">{{ number_format($riskScore['total_score'],1) }}</div>
      <span class="cd-hero-badge" style="color:{{ $rColor }};border-color:{{ $rColor }};background:rgba(255,255,255,.04)">{{ $rl }}</span>
    </div>
    @endif
  </div>
</div>

<div class="row g-4">
  {{-- LEFT --}}
  <div class="col-lg-8">

    @if(isset($riskScore['total_score']))
    <div class="cd-panel">
      <div class="cd-panel-head">
        <i class="bi bi-shield-exclamation"></i>Risk Score Breakdown
        <small>Weather({{ $riskScore['weather_weight'] }}%) + Inflation({{ $riskScore['inflation_weight'] }}%) + Currency({{ $riskScore['currency_weight'] }}%) + News({{ $riskScore['news_weight'] }}%)</small>
      </div>
      <div class="cd-panel-body">
        <div class="cd-risk-grid">
          @foreach([
            ['label'=>'Weather','score'=>$riskScore['weather_score'],'icon'=>'bi-cloud-sun','color'=>'var(--cyan)'],
            ['label'=>'Inflation','score'=>$riskScore['inflation_score'],'icon'=>'bi-graph-down','color'=>'var(--amber)'],
            ['label'=>'Currency','score'=>$riskScore['currency_score'],'icon'=>'bi-currency-exchange','color'=>'var(--gold)'],
            ['label'=>'News','score'=>$riskScore['news_sentiment_score'],'icon'=>'bi-newspaper','color'=>'var(--coral)'],
          ] as $c)
          <div class="cd-risk-item">
            <i class="bi {{ $c['icon'] }}" style="color:{{ $c['color'] }}"></i>
            <div class="cd-risk-value" style="color:{{ $c['color'] }}">{{ number_format($c['score'],1) }}</div>
            <div class="cd-risk-label">{{ $c['label'] }}</div>
          </div>
          @endforeach
        </div>
        <div class="d-flex justify-content-between small mb-1">
          <span class="text-muted" style="color:var(--text-dim)!important">Total</span>
          <span class="fw-semibold" style="font-family:'IBM Plex Mono',monospace">{{ number_format($riskScore['total_score'],1) }}/100</span>
        </div>
        <div class="cd-progress-track">
          <div class="cd-progress-fill" style="width:{{ $riskScore['total_score'] }}%;background:{{ $rColor }}"></div>
        </div>
        <div class="cd-progress-scale"><span>0 Low</span><span>30</span><span>60</span><span>80</span><span>100 Critical</span></div>
      </div>
    </div>
    @endif

    <div class="cd-panel">
      <div class="cd-panel-head"><i class="bi bi-bar-chart"></i>Economic Indicators <small>World Bank API</small></div>
      <div class="cd-panel-body">
        @if($economic && array_filter($economic))
        <div class="cd-econ-grid">
          @if(!empty($economic['gdp']))<div class="cd-econ-item"><div class="cd-econ-label">GDP</div><div class="cd-econ-value">@php $g=$economic['gdp'];echo $g>=1e12?'$'.round($g/1e12,2).'T':($g>=1e9?'$'.round($g/1e9,2).'B':'$'.number_format($g));@endphp</div></div>@endif
          @if(!empty($economic['inflation']))<div class="cd-econ-item"><div class="cd-econ-label">Inflasi</div><div class="cd-econ-value" style="color:{{ abs($economic['inflation'])>10?'var(--coral)':'var(--text)' }}">{{ number_format($economic['inflation'],2) }}%</div></div>@endif
          @if(!empty($economic['population']))<div class="cd-econ-item"><div class="cd-econ-label">Populasi</div><div class="cd-econ-value">@php $p=$economic['population'];echo $p>=1e9?round($p/1e9,2).'B':($p>=1e6?round($p/1e6,1).'M':number_format($p));@endphp</div></div>@endif
          @if(!empty($economic['exports']))<div class="cd-econ-item"><div class="cd-econ-label">Ekspor</div><div class="cd-econ-value" style="color:var(--cyan)">@php $e=$economic['exports'];echo $e>=1e12?'$'.round($e/1e12,2).'T':($e>=1e9?'$'.round($e/1e9,2).'B':'$'.number_format($e));@endphp</div></div>@endif
          @if(!empty($economic['imports']))<div class="cd-econ-item"><div class="cd-econ-label">Impor</div><div class="cd-econ-value" style="color:var(--coral)">@php $i=$economic['imports'];echo $i>=1e12?'$'.round($i/1e12,2).'T':($i>=1e9?'$'.round($i/1e9,2).'B':'$'.number_format($i));@endphp</div></div>@endif
          @if(!empty($economic['unemployment']))<div class="cd-econ-item"><div class="cd-econ-label">Pengangguran</div><div class="cd-econ-value">{{ number_format($economic['unemployment'],2) }}%</div></div>@endif
        </div>
        @else
        <div class="cd-empty"><i class="bi bi-cloud-slash"></i>Data ekonomi tidak tersedia (World Bank API).</div>
        @endif
      </div>
    </div>

    <div class="row g-3">
      <div class="col-md-6">
        <div class="cd-panel mb-0">
          <div class="cd-panel-head"><i class="bi bi-bar-chart" style="color:var(--cyan)"></i>GDP Trend</div>
          <div class="cd-panel-body"><canvas id="gdpChart" height="200"></canvas></div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="cd-panel mb-0">
          <div class="cd-panel-head"><i class="bi bi-graph-down-arrow" style="color:var(--coral)"></i>Inflation Trend</div>
          <div class="cd-panel-body"><canvas id="inflChart" height="200"></canvas></div>
        </div>
      </div>
    </div>
  </div>

  {{-- RIGHT --}}
  <div class="col-lg-4">
    @if($weather)
    @php
      $wc=$weather['weathercode']??0;
      $wicon=match(true){
        in_array($wc,[0,1])=>'☀️', in_array($wc,[2,3])=>'⛅', in_array($wc,[45,48])=>'🌫️',
        in_array($wc,[51,61,63])=>'🌦️', in_array($wc,[65,80,81,82])=>'🌧️', in_array($wc,[95,96,99])=>'⛈️', default=>'🌡️'
      };
    @endphp
    <div class="cd-weather-card">
      <div class="cd-weather-eyebrow">Cuaca Saat Ini · Open-Meteo API</div>
      <div class="cd-weather-icon">{{ $wicon }}</div>
      <div class="cd-weather-temp">{{ $weather['temperature_2m']??'--' }}°C</div>
      <div class="cd-weather-desc">{{ $weather['weather_description']??'' }}</div>
      <div class="cd-weather-strip">
        <div><div class="cd-weather-strip-label">HUJAN</div><div class="cd-weather-strip-value">{{ $weather['precipitation']??0 }}mm</div></div>
        <div><div class="cd-weather-strip-label">ANGIN</div><div class="cd-weather-strip-value">{{ $weather['windspeed_10m']??0 }}km/h</div></div>
        <div><div class="cd-weather-strip-label">LEMBAB</div><div class="cd-weather-strip-value">{{ $weather['humidity']??'--' }}%</div></div>
      </div>
      @if($weather['is_storm']||$weather['is_heavy_rain']||$weather['is_strong_wind'])
      <div class="cd-weather-flags">
        @if($weather['is_storm'])<span class="cd-weather-flag" style="color:var(--coral);border-color:rgba(239,91,91,.4)">⛈️ Storm</span>@endif
        @if($weather['is_heavy_rain'])<span class="cd-weather-flag" style="color:#5EA8E0;border-color:rgba(94,168,224,.4)">🌧️ Heavy Rain</span>@endif
        @if($weather['is_strong_wind'])<span class="cd-weather-flag" style="color:var(--amber);border-color:rgba(240,169,71,.4)">💨 Strong Wind</span>@endif
      </div>
      @endif
      <div class="cd-weather-risk">Weather Risk: <b>{{ number_format($weather['weather_risk_score']??0,1) }}/100</b></div>
    </div>
    @endif

    <div class="cd-panel">
      <div class="cd-panel-body d-grid gap-2">
        <button id="wlBtn" class="cd-action-btn cd-action-btn--wl {{ $isWatchlisted?'is-active':'' }}"
          onclick="{{ $isWatchlisted?'removeWl':'addWl' }}('{{ $country->code }}')">
          <i class="bi bi-star{{ $isWatchlisted?'-fill':'' }}"></i>
          {{ $isWatchlisted?'Hapus dari Watchlist':'Tambah ke Watchlist' }}
        </button>
        <a href="{{ route('comparison.index') }}?a={{ $country->code }}" class="cd-action-btn"><i class="bi bi-bar-chart-steps"></i>Bandingkan Negara</a>
        <a href="{{ route('visualization.show',$country->code) }}" class="cd-action-btn"><i class="bi bi-graph-up"></i>Data Visualization</a>
        <a href="{{ route('weather.show',$country->code) }}" class="cd-action-btn"><i class="bi bi-cloud-sun"></i>Weather Detail</a>
        <a href="{{ route('ports.index') }}?country={{ $country->code }}" class="cd-action-btn"><i class="bi bi-anchor"></i>Pelabuhan</a>
        <a href="{{ route('currency.show',$country->code) }}" class="cd-action-btn"><i class="bi bi-currency-exchange"></i>Currency Detail</a>
      </div>
    </div>

    <div class="cd-panel mb-0">
      <div class="cd-panel-head"><i class="bi bi-info-circle"></i>Info Negara</div>
      <div class="cd-panel-body">
        <div class="cd-info-row"><span class="cd-info-label">Kode ISO</span><span class="cd-info-value">{{ $country->code }} / {{ $country->code3 }}</span></div>
        <div class="cd-info-row"><span class="cd-info-label">Region</span><span class="cd-info-value">{{ $country->region }}</span></div>
        <div class="cd-info-row"><span class="cd-info-label">Ibu Kota</span><span class="cd-info-value">{{ $country->capital }}</span></div>
        <div class="cd-info-row"><span class="cd-info-label">Mata Uang</span><span class="cd-info-value">{{ $country->currency_code }}</span></div>
        @if($country->population)
        <div class="cd-info-row"><span class="cd-info-label">Populasi</span><span class="cd-info-value">@php $p=$country->population;echo $p>=1e9?round($p/1e9,2).'B':($p>=1e6?round($p/1e6,1).'M':number_format($p));@endphp</span></div>
        @endif
        @if($country->languages)
        <div class="cd-info-row"><span class="cd-info-label">Bahasa</span><span class="cd-info-value">{{ implode(', ',array_slice((array)$country->languages,0,3)) }}</span></div>
        @endif
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@push('scripts')
<script>
const gridColor='rgba(255,255,255,.06)', tickColor='#7FA0B8', fontMono={family:'IBM Plex Mono',size:10};

const gdpData=@json($gdpTrend??[]),inflData=@json($inflationTrend??[]);

if(gdpData.length){
  new Chart(document.getElementById('gdpChart').getContext('2d'),{
    type:'bar',
    data:{labels:gdpData.map(d=>d.year),datasets:[{data:gdpData.map(d=>d.value),backgroundColor:'rgba(63,208,201,.75)',borderRadius:4}]},
    options:{responsive:true,plugins:{legend:{display:false}},scales:{
      y:{ticks:{callback:v=>v>=1e12?'$'+(v/1e12).toFixed(1)+'T':v>=1e9?'$'+(v/1e9).toFixed(1)+'B':'$'+v,color:tickColor,font:fontMono},grid:{color:gridColor}},
      x:{ticks:{color:tickColor,font:fontMono},grid:{display:false}}
    }}
  });
} else {
  document.getElementById('gdpChart').parentElement.innerHTML='<div class="cd-empty"><i class="bi bi-bar-chart"></i>Data GDP tidak tersedia</div>';
}

if(inflData.length){
  const ctx=document.getElementById('inflChart').getContext('2d');
  const grad=ctx.createLinearGradient(0,0,0,200);
  grad.addColorStop(0,'rgba(239,91,91,.25)'); grad.addColorStop(1,'rgba(239,91,91,0)');
  new Chart(ctx,{
    type:'line',
    data:{labels:inflData.map(d=>d.year),datasets:[{data:inflData.map(d=>d.value),borderColor:'#EF5B5B',backgroundColor:grad,tension:.4,fill:true,pointRadius:4,pointBackgroundColor:'#EF5B5B'}]},
    options:{responsive:true,plugins:{legend:{display:false}},scales:{
      y:{ticks:{callback:v=>v+'%',color:tickColor,font:fontMono},grid:{color:gridColor}},
      x:{ticks:{color:tickColor,font:fontMono},grid:{display:false}}
    }}
  });
} else {
  document.getElementById('inflChart').parentElement.innerHTML='<div class="cd-empty"><i class="bi bi-graph-down-arrow"></i>Data inflasi tidak tersedia</div>';
}

function addWl(code){
  ajaxPost('{{ route('watchlist.add') }}',{country_code:code},d=>{
    if(d.success){
      const btn=document.getElementById('wlBtn');
      btn.classList.add('is-active');
      btn.innerHTML='<i class="bi bi-star-fill"></i>Hapus dari Watchlist';
      btn.setAttribute('onclick','removeWl(\''+code+'\')');
      showT(d.message,'success');
    } else showT(d.message||'Gagal','danger');
  });
}
function removeWl(){ window.location='{{ route('watchlist.index') }}'; }
function showT(msg,type){
  const e=document.createElement('div');
  e.className=`cd-toast cd-toast--${type}`;
  e.textContent=msg;
  document.body.appendChild(e);
  setTimeout(()=>e.remove(),3000);
}
</script>
@endpush