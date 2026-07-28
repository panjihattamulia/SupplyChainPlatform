@extends('layouts.app')
@section('title','Cuaca — '.$country->name)
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('weather.index') }}">Weather</a></li>
<li class="breadcrumb-item active">{{ $country->name }}</li>
@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#0A1E2E;
  --surface:#102A3D;
  --surface-raised:#16374C;
  --line:#20415A;
  --text:#EAF2F6;
  --text-dim:#7FA0B8;
  --cyan:#3FD0C9;
  --amber:#F0A947;
  --coral:#EF5B5B;
  --coral-deep:#C23A3A;
}
.wx-wrap{ font-family:'Inter',sans-serif; color:var(--text); }
.wx-eyebrow{
  font-family:'IBM Plex Mono',monospace; font-size:.68rem; letter-spacing:.18em;
  text-transform:uppercase; color:var(--cyan); margin-bottom:.35rem; display:flex; align-items:center; gap:.5rem;
}
.wx-eyebrow::before{ content:''; width:6px; height:6px; border-radius:50%; background:var(--cyan);
  box-shadow:0 0 0 3px rgba(63,208,201,.25); }
.wx-title{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.9rem; margin:0; color:var(--text); }
.wx-coords{ font-family:'IBM Plex Mono',monospace; font-size:.75rem; color:var(--text-dim); margin-top:.15rem; }

.wx-station{
  background:radial-gradient(circle at 30% 0%,#153a52 0%,var(--ink) 65%);
  border:1px solid var(--line); border-radius:18px; padding:1.75rem 1.5rem 1.5rem;
}

/* Gauge */
.wx-gauge-shell{ position:relative; width:210px; height:180px; margin:0 auto; }
.wx-gauge-pulse{ position:absolute; inset:0; border-radius:50%; }
@media (prefers-reduced-motion: no-preference){
  .wx-gauge-pulse::after{
    content:''; position:absolute; inset:18%; border-radius:50%;
    box-shadow:0 0 0 0 rgba(63,208,201,.35); animation:wxpulse 2.6s ease-out infinite;
  }
}
@keyframes wxpulse{ 0%{box-shadow:0 0 0 0 rgba(63,208,201,.35);} 100%{box-shadow:0 0 0 22px rgba(63,208,201,0);} }
.wx-gauge-readout{ position:absolute; left:50%; top:64%; transform:translate(-50%,-50%); text-align:center; }
.wx-gauge-value{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:2rem; line-height:1; color:var(--text); }
.wx-gauge-max{ font-family:'IBM Plex Mono',monospace; font-size:.7rem; color:var(--text-dim); }
.wx-gauge-tag{
  font-family:'IBM Plex Mono',monospace; font-size:.62rem; letter-spacing:.12em; text-transform:uppercase;
  padding:.2rem .55rem; border-radius:20px; margin-top:.4rem; display:inline-block; border:1px solid transparent;
}

.wx-temp-hero{ text-align:center; margin-top:.25rem; }
.wx-temp-icon{ font-size:2.6rem; line-height:1; }
.wx-temp-value{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:2.6rem; letter-spacing:-.02em; }
.wx-temp-desc{ font-family:'Inter',sans-serif; color:var(--text-dim); font-size:.85rem; text-transform:capitalize; }

.wx-readings{ display:grid; grid-template-columns:repeat(3,1fr); gap:.6rem; margin-top:1.25rem; }
.wx-reading{
  background:var(--surface); border:1px solid var(--line); border-radius:12px; padding:.65rem .5rem; text-align:center;
}
.wx-reading-label{ font-family:'IBM Plex Mono',monospace; font-size:.6rem; letter-spacing:.1em; text-transform:uppercase; color:var(--text-dim); }
.wx-reading-value{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:1.05rem; color:var(--text); margin-top:.2rem; }

.wx-flags{ display:flex; flex-wrap:wrap; gap:.4rem; justify-content:center; margin-top:1rem; }
.wx-flag{
  font-family:'IBM Plex Mono',monospace; font-size:.65rem; letter-spacing:.06em; padding:.3rem .6rem;
  border-radius:20px; border:1px solid; display:inline-flex; align-items:center; gap:.3rem;
}
.wx-flag--storm{ color:var(--coral); border-color:rgba(239,91,91,.4); background:rgba(239,91,91,.08); }
.wx-flag--rain{ color:#5EA8E0; border-color:rgba(94,168,224,.4); background:rgba(94,168,224,.08); }
.wx-flag--wind{ color:var(--amber); border-color:rgba(240,169,71,.4); background:rgba(240,169,71,.08); }

.wx-nav-card{ background:var(--ink); border:1px solid var(--line); border-radius:14px; padding:.9rem; margin-top:1rem; }
.wx-btn{
  font-family:'Inter',sans-serif; font-weight:500; font-size:.85rem; border-radius:10px; padding:.55rem .9rem;
  border:1px solid var(--line); color:var(--text); background:transparent; display:flex; align-items:center;
  gap:.5rem; text-decoration:none; transition:border-color .15s, background .15s;
}
.wx-btn:hover{ border-color:var(--cyan); background:rgba(63,208,201,.08); color:var(--text); }
.wx-btn + .wx-btn{ margin-top:.5rem; }

.wx-panel{ background:var(--surface); border:1px solid var(--line); border-radius:18px; overflow:hidden; margin-bottom:1.25rem; }
.wx-panel-head{
  font-family:'IBM Plex Mono',monospace; font-size:.72rem; letter-spacing:.1em; text-transform:uppercase;
  color:var(--text-dim); padding:.9rem 1.1rem; border-bottom:1px solid var(--line); display:flex; align-items:center; gap:.5rem;
}
.wx-panel-head i{ color:var(--cyan); }
.wx-panel-body{ padding:1.1rem; }

.wx-map{ height:260px; filter:saturate(.9); }

.wx-day{
  background:var(--surface-raised); border:1px solid var(--line); border-radius:12px; padding:.75rem .4rem;
  text-align:center; transition:transform .15s, border-color .15s;
}
.wx-day:hover{ transform:translateY(-3px); border-color:var(--cyan); }
.wx-day-name{ font-family:'IBM Plex Mono',monospace; font-size:.62rem; letter-spacing:.08em; text-transform:uppercase; color:var(--text-dim); }
.wx-day-icon{ font-size:1.3rem; margin:.3rem 0; }
.wx-day-max{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:.95rem; color:var(--text); }
.wx-day-min{ font-family:'IBM Plex Mono',monospace; font-size:.75rem; color:var(--text-dim); }
.wx-day-rain{ font-family:'IBM Plex Mono',monospace; font-size:.62rem; color:var(--cyan); margin-top:.2rem; }

.wx-empty{ text-align:center; color:var(--text-dim); padding:2.5rem 1rem; font-family:'Inter',sans-serif; }
.wx-empty i{ font-size:2.2rem; opacity:.3; display:block; margin-bottom:.6rem; }
</style>
@endpush

@section('content')
<div class="wx-wrap">
<div class="row g-4">
  <div class="col-lg-4">

    <div class="wx-station mb-3">
      <div class="wx-eyebrow">Weather Station</div>
      <div class="d-flex align-items-center gap-2">
        <span style="font-size:1.6rem">{{ $country->flag_emoji??'🏳️' }}</span>
        <div>
          <h1 class="wx-title">{{ $country->name }}</h1>
          <div class="wx-coords">{{ number_format($country->latitude??0,2) }}°, {{ number_format($country->longitude??0,2) }}°</div>
        </div>
      </div>

      @if($weather)
      @php
        $wc=$weather['weathercode']??0;
        $icon=match(true){
          in_array($wc,[0,1])  =>'☀️',
          in_array($wc,[2,3])  =>'⛅',
          in_array($wc,[45,48])=>'🌫️',
          in_array($wc,[51,61,63])=>'🌦️',
          in_array($wc,[65,80,81,82])=>'🌧️',
          in_array($wc,[95,96,99])=>'⛈️',
          default=>'🌡️'
        };
        $wr = min(100,max(0,$weather['weather_risk_score']??0));
        $riskAngle = -135 + (270 * ($wr/100));
        [$riskLabel,$riskColor,$riskBg] = match(true){
          $wr<=30 => ['✅ Low Risk','var(--cyan)','rgba(63,208,201,.12)'],
          $wr<=60 => ['⚠️ Medium Risk','var(--amber)','rgba(240,169,71,.12)'],
          $wr<=80 => ['🔴 High Risk','var(--coral)','rgba(239,91,91,.12)'],
          default => ['🚨 Critical','var(--coral-deep)','rgba(194,58,58,.16)'],
        };
      @endphp

      <div class="wx-gauge-shell mt-3">
        <div class="wx-gauge-pulse"></div>
        <svg viewBox="0 0 200 200" width="210" height="180">
          <path d="M 36.36 163.64 A 90 90 0 0 1 27.19 47.1" fill="none" stroke="var(--cyan)" stroke-width="10" stroke-linecap="round" opacity=".85"/>
          <path d="M 27.19 47.1 A 90 90 0 0 1 140.86 19.81" fill="none" stroke="var(--amber)" stroke-width="10" stroke-linecap="round" opacity=".85"/>
          <path d="M 140.86 19.81 A 90 90 0 0 1 188.89 85.92" fill="none" stroke="var(--coral)" stroke-width="10" stroke-linecap="round" opacity=".85"/>
          <path d="M 188.89 85.92 A 90 90 0 0 1 163.64 163.64" fill="none" stroke="var(--coral-deep)" stroke-width="10" stroke-linecap="round" opacity=".85"/>
          <line x1="100" y1="100" x2="100" y2="26" stroke="#EAF2F6" stroke-width="3" stroke-linecap="round"
                transform="rotate({{ $riskAngle }} 100 100)"/>
          <circle cx="100" cy="100" r="7" fill="#EAF2F6"/>
          <circle cx="100" cy="100" r="3" fill="var(--ink)"/>
        </svg>
        <div class="wx-gauge-readout">
          <div class="wx-gauge-value">{{ number_format($wr,1) }}</div>
          <div class="wx-gauge-max">RISK / 100</div>
          <span class="wx-gauge-tag" style="color:{{ $riskColor }};background:{{ $riskBg }};border-color:{{ $riskColor }}">{{ $riskLabel }}</span>
        </div>
      </div>

      <div class="wx-temp-hero">
        <div class="wx-temp-icon">{{ $icon }}</div>
        <div class="wx-temp-value">{{ $weather['temperature_2m']??'--' }}°C</div>
        <div class="wx-temp-desc">{{ $weather['weather_description']??'' }}</div>
      </div>

      <div class="wx-readings">
        <div class="wx-reading"><div class="wx-reading-label">Hujan</div><div class="wx-reading-value">{{ $weather['precipitation']??0 }}mm</div></div>
        <div class="wx-reading"><div class="wx-reading-label">Angin</div><div class="wx-reading-value">{{ $weather['windspeed_10m']??0 }}km/h</div></div>
        <div class="wx-reading"><div class="wx-reading-label">Lembab</div><div class="wx-reading-value">{{ $weather['humidity']??'--' }}%</div></div>
      </div>

      @if($weather['is_storm']||$weather['is_heavy_rain']||$weather['is_strong_wind'])
      <div class="wx-flags">
        @if($weather['is_storm'])<span class="wx-flag wx-flag--storm">⛈️ STORM</span>@endif
        @if($weather['is_heavy_rain'])<span class="wx-flag wx-flag--rain">🌧️ HEAVY RAIN</span>@endif
        @if($weather['is_strong_wind'])<span class="wx-flag wx-flag--wind">💨 STRONG WIND</span>@endif
      </div>
      @endif

      @else
      <div class="wx-empty">
        <i class="bi bi-cloud-slash"></i>
        Data cuaca tidak tersedia untuk stasiun ini.
      </div>
      @endif
    </div>

    <div class="wx-nav-card">
      <a href="{{ route('countries.show',$country->code) }}" class="wx-btn">
        <i class="bi bi-globe"></i>Country Dashboard
      </a>
      <a href="{{ route('weather.index') }}" class="wx-btn">
        <i class="bi bi-arrow-left"></i>Kembali ke Peta
      </a>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="wx-panel">
      <div class="wx-panel-head"><i class="bi bi-geo-alt"></i>Lokasi — {{ $country->name }}</div>
      <div class="wx-map" id="cMap"></div>
    </div>

    <div class="wx-panel mb-0">
      <div class="wx-panel-head"><i class="bi bi-calendar-week"></i>Prakiraan 7 Hari</div>
      <div class="wx-panel-body">
        @if($forecast && isset($forecast['daily']))
        @php
        $fd  = $forecast['daily'];
        $wicons = [0=>'☀️',1=>'🌤️',2=>'⛅',3=>'☁️',45=>'🌫️',51=>'🌦️',61=>'🌦️',63=>'🌧️',65=>'🌧️',80=>'🌧️',82=>'⛈️',95=>'⛈️',99=>'⛈️'];
        @endphp
        <div class="row g-2 mb-4">
          @foreach($fd['time']??[] as $i=>$date)
          <div class="col">
            <div class="wx-day">
              <div class="wx-day-name">{{ \Carbon\Carbon::parse($date)->format('D') }}</div>
              <div class="wx-day-icon">{{ $wicons[$fd['weathercode'][$i]??0]??'🌡️' }}</div>
              <div class="wx-day-max">{{ round($fd['temperature_2m_max'][$i]??0) }}°</div>
              <div class="wx-day-min">{{ round($fd['temperature_2m_min'][$i]??0) }}°</div>
              @if(($fd['precipitation_sum'][$i]??0)>0)
              <div class="wx-day-rain">💧{{ round($fd['precipitation_sum'][$i],1) }}mm</div>
              @endif
            </div>
          </div>
          @endforeach
        </div>
        <canvas id="fChart" height="110"></canvas>
        @else
        <div class="wx-empty">
          <i class="bi bi-cloud-slash"></i>Data prakiraan tidak tersedia
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@push('scripts')
<script>
const cm=L.map('cMap',{zoom:4,center:[{{ $country->latitude??0 }},{{ $country->longitude??0 }}],zoomControl:false});
L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',{
  attribution:'© OpenStreetMap © CARTO', subdomains:'abcd', maxZoom:19
}).addTo(cm);
const wxIcon = L.divIcon({
  className:'', html:'<div style="width:14px;height:14px;border-radius:50%;background:#3FD0C9;box-shadow:0 0 0 5px rgba(63,208,201,.25);"></div>',
  iconSize:[14,14], iconAnchor:[7,7]
});
L.marker([{{ $country->latitude??0 }},{{ $country->longitude??0 }}],{icon:wxIcon}).addTo(cm)
  .bindPopup('<b>{{ $country->name }}</b>').openPopup();

@if($forecast && isset($forecast['daily']))
@php $fd=$forecast['daily']; @endphp
new Chart(document.getElementById('fChart').getContext('2d'),{
  type:'line',
  data:{
    labels:@json(array_map(fn($x)=>\Carbon\Carbon::parse($x)->format('D'),$fd['time']??[])),
    datasets:[
      {label:'Max°C',data:@json($fd['temperature_2m_max']??[]),borderColor:'#EF5B5B',backgroundColor:'rgba(239,91,91,.08)',tension:.4,fill:true,pointRadius:3,pointBackgroundColor:'#EF5B5B'},
      {label:'Min°C',data:@json($fd['temperature_2m_min']??[]),borderColor:'#3FD0C9',backgroundColor:'rgba(63,208,201,.08)',tension:.4,fill:true,pointRadius:3,pointBackgroundColor:'#3FD0C9'}
    ]
  },
  options:{
    responsive:true,
    plugins:{legend:{position:'top',labels:{color:'#7FA0B8',font:{family:'IBM Plex Mono',size:11}}}},
    scales:{
      y:{ticks:{callback:v=>v+'°C',color:'#7FA0B8',font:{family:'IBM Plex Mono',size:10}},grid:{color:'rgba(255,255,255,.05)'}},
      x:{ticks:{color:'#7FA0B8',font:{family:'IBM Plex Mono',size:10}},grid:{display:false}}
    }
  }
});
@endif
</script>
@endpush