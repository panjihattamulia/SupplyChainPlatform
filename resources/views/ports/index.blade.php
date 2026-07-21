@extends('layouts.app')
@section('title','Port Location Dashboard')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Port Locations</li>
@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{
  --chart-bg:#EEF2F4;
  --chart-surface:#FFFFFF;
  --chart-ink:#0A2540;
  --chart-ink-soft:#4A6178;
  --chart-line:#D6DFE5;
  --chart-blue:#2C6E8E;
  --chart-blue-deep:#0A2540;
  --sig-low:#2E7D5B;
  --sig-moderate:#C97F00;
  --sig-high:#C1442E;
  --sig-critical:#14181B;
  --font-display:'Space Grotesk',sans-serif;
  --font-body:'Inter',sans-serif;
  --font-mono:'IBM Plex Mono',monospace;
}

.pld-wrap{font-family:var(--font-body);color:var(--chart-ink);}
.pld-wrap *{box-sizing:border-box;}

/* ---- Header / instrument strip ---- */
.pld-header{
  display:flex;justify-content:space-between;align-items:flex-end;
  margin-bottom:1.75rem;padding-bottom:1rem;border-bottom:1px solid var(--chart-line);
}
.pld-eyebrow{
  font-family:var(--font-mono);font-size:.7rem;letter-spacing:.14em;text-transform:uppercase;
  color:var(--chart-blue);margin:0 0 .35rem;
}
.pld-title{
  font-family:var(--font-display);font-weight:700;font-size:1.65rem;margin:0;
  color:var(--chart-ink);letter-spacing:-.01em;
}
.pld-title i{color:var(--chart-blue);margin-right:.5rem;}
.pld-meta{
  font-family:var(--font-mono);font-size:.75rem;color:var(--chart-ink-soft);
  text-align:right;
}
.pld-meta strong{color:var(--chart-ink);}

/* ---- Stat strip styled like an instrument panel ---- */
.pld-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:var(--chart-line);
  border:1px solid var(--chart-line);border-radius:10px;overflow:hidden;margin-bottom:1.5rem;}
.pld-stat{background:var(--chart-surface);padding:1rem 1.1rem;position:relative;}
.pld-stat-label{font-family:var(--font-mono);font-size:.66rem;letter-spacing:.08em;
  text-transform:uppercase;color:var(--chart-ink-soft);margin-bottom:.4rem;display:flex;align-items:center;gap:.4rem;}
.pld-stat-dot{width:7px;height:7px;border-radius:50%;display:inline-block;flex:none;}
.pld-stat-value{font-family:var(--font-display);font-weight:700;font-size:1.9rem;line-height:1;color:var(--chart-ink);}
.pld-stat.total .pld-stat-dot{background:var(--chart-blue);}
.pld-stat.low .pld-stat-dot{background:var(--sig-low);}
.pld-stat.moderate .pld-stat-dot{background:var(--sig-moderate);}
.pld-stat.high .pld-stat-dot{background:var(--sig-high);}

/* ---- Control bar ---- */
.pld-controls{
  background:var(--chart-surface);border:1px solid var(--chart-line);border-radius:10px;
  padding:.85rem 1rem;margin-bottom:1.25rem;display:flex;gap:.75rem;flex-wrap:wrap;align-items:center;
}
.pld-controls .pld-search{flex:1 1 260px;position:relative;}
.pld-controls .pld-search i{position:absolute;left:.85rem;top:50%;transform:translateY(-50%);color:var(--chart-ink-soft);font-size:.9rem;}
.pld-controls input.form-control,
.pld-controls select.form-select{
  border:1px solid var(--chart-line);border-radius:7px;font-family:var(--font-body);
  font-size:.86rem;background:var(--chart-bg);color:var(--chart-ink);
  transition:border-color .15s ease, background .15s ease;
}
.pld-controls input.form-control{padding-left:2.25rem;}
.pld-controls input.form-control:focus,
.pld-controls select.form-select:focus{
  border-color:var(--chart-blue);background:#fff;box-shadow:0 0 0 3px rgba(44,110,142,.12);
}
.pld-controls select.form-select{flex:0 0 auto;width:auto;min-width:170px;}

/* ---- Panels ---- */
.pld-panel{background:var(--chart-surface);border:1px solid var(--chart-line);border-radius:12px;overflow:hidden;height:100%;}
.pld-panel-head{
  display:flex;justify-content:space-between;align-items:center;
  padding:.9rem 1.1rem;border-bottom:1px solid var(--chart-line);
}
.pld-panel-head h2{
  font-family:var(--font-display);font-weight:600;font-size:.95rem;margin:0;color:var(--chart-ink);
  display:flex;align-items:center;gap:.5rem;
}
.pld-panel-head .hint{font-family:var(--font-mono);font-size:.68rem;color:var(--chart-ink-soft);font-weight:400;}
.pld-count{
  font-family:var(--font-mono);font-size:.72rem;background:var(--chart-ink);color:#fff;
  padding:.15rem .55rem;border-radius:20px;
}

/* ---- Map with chart-corner ticks (signature detail) ---- */
.pld-map-frame{position:relative;}
#portMap{height:500px;background:var(--chart-bg);}
.pld-map-frame::before,.pld-map-frame::after,
.pld-tick-tl,.pld-tick-br{position:absolute;width:16px;height:16px;pointer-events:none;z-index:500;}
.pld-tick-tl{top:10px;left:10px;border-top:2px solid var(--chart-blue);border-left:2px solid var(--chart-blue);opacity:.55;}
.pld-tick-br{bottom:10px;right:10px;border-bottom:2px solid var(--chart-blue);border-right:2px solid var(--chart-blue);opacity:.55;}

/* ---- Manifest-style list ---- */
.pld-list{max-height:460px;overflow-y:auto;}
.port-item{
  display:flex;align-items:center;justify-content:space-between;gap:.75rem;
  padding:.7rem 1.1rem;border-bottom:1px solid var(--chart-line);border-left:3px solid transparent;
  cursor:pointer;transition:background .12s ease,border-color .12s ease;
}
.port-item:hover{background:var(--chart-bg);}
.port-item[data-cong="low"]{border-left-color:var(--sig-low);}
.port-item[data-cong="moderate"]{border-left-color:var(--sig-moderate);}
.port-item[data-cong="high"]{border-left-color:var(--sig-high);}
.port-item[data-cong="critical"]{border-left-color:var(--sig-critical);}
.port-name{font-weight:600;font-size:.86rem;color:var(--chart-ink);}
.port-sub{font-family:var(--font-mono);font-size:.68rem;color:var(--chart-ink-soft);margin-top:.1rem;}
.port-code{font-family:var(--font-mono);letter-spacing:.03em;}
.pld-flag{
  font-family:var(--font-mono);font-size:.66rem;letter-spacing:.05em;text-transform:uppercase;
  padding:.22rem .55rem;border-radius:5px;color:#fff;flex:none;
}
.pld-flag.low{background:var(--sig-low);}
.pld-flag.moderate{background:var(--sig-moderate);}
.pld-flag.high{background:var(--sig-high);}
.pld-flag.critical{background:var(--sig-critical);}

.pld-empty{padding:2.5rem 1rem;text-align:center;color:var(--chart-ink-soft);font-family:var(--font-mono);font-size:.8rem;}

@media (max-width:767px){
  .pld-stats{grid-template-columns:repeat(2,1fr);}
  .pld-header{flex-direction:column;align-items:flex-start;gap:.5rem;}
  .pld-meta{text-align:left;}
}
</style>
@endpush

@section('content')
<div class="pld-wrap">

  <div class="pld-header">
    <div>
      <p class="pld-eyebrow">Vessel Traffic &amp; Congestion Monitor</p>
      <h1 class="pld-title"><i class="bi bi-anchor"></i>Port Location Dashboard</h1>
    </div>
    <div class="pld-meta">Source: <strong>World Port Index</strong><br>{{ $stats['total'] }} pelabuhan tercatat</div>
  </div>

  <div class="pld-stats">
    <div class="pld-stat total">
      <div class="pld-stat-label"><span class="pld-stat-dot"></span>Total Pelabuhan</div>
      <div class="pld-stat-value">{{ $stats['total'] }}</div>
    </div>
    <div class="pld-stat low">
      <div class="pld-stat-label"><span class="pld-stat-dot"></span>Low Congestion</div>
      <div class="pld-stat-value">{{ $stats['low'] }}</div>
    </div>
    <div class="pld-stat moderate">
      <div class="pld-stat-label"><span class="pld-stat-dot"></span>Moderate</div>
      <div class="pld-stat-value">{{ $stats['moderate'] }}</div>
    </div>
    <div class="pld-stat high">
      <div class="pld-stat-label"><span class="pld-stat-dot"></span>High / Critical</div>
      <div class="pld-stat-value">{{ $stats['high'] }}</div>
    </div>
  </div>

  <div class="pld-controls">
    <div class="pld-search">
      <i class="bi bi-search"></i>
      <input type="text" id="psearch" class="form-control" placeholder="Cari nama atau kode pelabuhan…">
    </div>
    <select id="cfilter" class="form-select">
      <option value="">Semua Negara</option>
      @foreach($countries as $c)
        <option value="{{ $c->code }}" {{ request('country')===$c->code?'selected':'' }}>{{ $c->flag_emoji }} {{ $c->name }}</option>
      @endforeach
    </select>
    <select id="congest" class="form-select">
      <option value="">Semua Kongesti</option>
      <option value="low">Low</option>
      <option value="moderate">Moderate</option>
      <option value="high">High</option>
      <option value="critical">Critical</option>
    </select>
  </div>

  <div class="row g-4">
    <div class="col-lg-7">
      <div class="pld-panel">
        <div class="pld-panel-head">
          <h2><i class="bi bi-map"></i>Peta Pelabuhan Dunia</h2>
          <span class="hint">klik marker atau baris untuk fokus</span>
        </div>
        <div class="pld-map-frame">
          <div class="pld-tick-tl"></div><div class="pld-tick-br"></div>
          <div id="portMap"></div>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="pld-panel">
        <div class="pld-panel-head">
          <h2><i class="bi bi-list-ul"></i>Daftar Pelabuhan</h2>
          <span class="pld-count" id="pcnt">{{ $ports->count() }}</span>
        </div>
        <div class="pld-list" id="pldList">
          @forelse($ports as $p)
          <div class="port-item"
            data-country="{{ $p->country_code }}" data-name="{{ strtolower($p->port_name) }}"
            data-code="{{ strtolower($p->port_code) }}" data-cong="{{ $p->congestion_level }}"
            data-lat="{{ $p->latitude }}" data-lng="{{ $p->longitude }}"
            onclick="focusPort({{ $p->latitude ?? 0 }},{{ $p->longitude ?? 0 }},'{{ addslashes($p->port_name) }}')">
            <div>
              <div class="port-name">{{ $p->port_name }}</div>
              <div class="port-sub">{{ $p->country_name }} · <span class="port-code">{{ $p->port_code }}</span></div>
            </div>
            <span class="pld-flag {{ $p->congestion_level }}">{{ ucfirst($p->congestion_level) }}</span>
          </div>
          @empty
          <div class="pld-empty">Tidak ada data pelabuhan.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
const pMap=L.map('portMap',{zoom:2,center:[20,0]});
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap',maxZoom:18}).addTo(pMap);

const mks=@json($markers??[]);
const mMap={};
const cc={low:'#2E7D5B',moderate:'#C97F00',high:'#C1442E',critical:'#14181B'};

mks.forEach(p=>{
  if(!p.lat||!p.lng)return;
  const col=cc[p.congestion]||'#4A6178';
  const m=L.circleMarker([p.lat,p.lng],{radius:7,color:'#fff',weight:2,fillColor:col,fillOpacity:.9}).addTo(pMap);
  m.bindPopup(
    `<div style="font-family:'Inter',sans-serif;min-width:180px">`+
    `<div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:.9rem;margin-bottom:2px">${p.name}</div>`+
    `<div style="font-family:'IBM Plex Mono',monospace;font-size:.7rem;color:#4A6178;margin-bottom:6px">${p.code||'—'}</div>`+
    `<div style="font-size:.78rem;margin-bottom:6px">📍 ${p.country} · ⚓ ${p.harbor_size}</div>`+
    `<span style="background:${col};color:#fff;padding:2px 9px;border-radius:5px;font-family:'IBM Plex Mono',monospace;font-size:.68rem;letter-spacing:.03em;text-transform:uppercase">`+
    `${p.congestion} (${p.congestion_score.toFixed(0)})</span></div>`
  );
  mMap[p.name.toLowerCase()]=m;
});

function focusPort(lat,lng,name){
  pMap.setView([lat,lng],7);
  const m=mMap[name.toLowerCase()];
  if(m)m.openPopup();
}

function doFilter(){
  const q=document.getElementById('psearch').value.toLowerCase();
  const ct=document.getElementById('cfilter').value;
  const cg=document.getElementById('congest').value;
  let cnt=0;
  document.querySelectorAll('.port-item').forEach(el=>{
    const ok=(!q||el.dataset.name.includes(q)||el.dataset.code.includes(q))&&(!ct||el.dataset.country===ct)&&(!cg||el.dataset.cong===cg);
    el.style.display=ok?'':'none';
    if(ok)cnt++;
  });
  document.getElementById('pcnt').textContent=cnt;
}
document.getElementById('psearch').addEventListener('input',doFilter);
document.getElementById('cfilter').addEventListener('change',doFilter);
document.getElementById('congest').addEventListener('change',doFilter);
@if(request('country'))document.getElementById('cfilter').value='{{ request('country') }}';doFilter();@endif
</script>
@endpush