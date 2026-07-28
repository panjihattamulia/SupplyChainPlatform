@extends('layouts.app')
@section('title','Currency Impact Dashboard')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Currency Impact</li>
@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#0A1E2E; --surface:#102A3D; --surface-raised:#16374C; --line:#20415A;
  --text:#EAF2F6; --text-dim:#7FA0B8;
  --gold:#F0B84B; --gold-dim:#C99A3E;
  --up:#EF5B5B; --down:#3FD0C9;
}
.cid-wrap{ font-family:'Inter',sans-serif; color:var(--text); }
.cid-eyebrow{ font-family:'IBM Plex Mono',monospace; font-size:.68rem; letter-spacing:.18em; text-transform:uppercase; color:var(--gold); display:flex; align-items:center; gap:.5rem; margin-bottom:.3rem; }
.cid-eyebrow::before{ content:''; width:6px; height:6px; border-radius:50%; background:var(--gold); box-shadow:0 0 0 3px rgba(240,184,75,.25); }
.cid-title{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.6rem; margin:0; }

.cid-base-form{ display:flex; align-items:center; gap:.6rem; }
.cid-base-label{ font-family:'IBM Plex Mono',monospace; font-size:.68rem; letter-spacing:.08em; text-transform:uppercase; color:var(--text-dim); }
.cid-select{
  background:var(--surface); border:1px solid var(--line); color:var(--text); border-radius:8px;
  padding:.4rem .7rem; font-family:'IBM Plex Mono',monospace; font-size:.82rem;
}
.cid-select:focus{ outline:none; border-color:var(--gold); }
.cid-select option{ background:var(--surface); }

/* Stat strip */
.cid-stat{ background:var(--surface); border:1px solid var(--line); border-radius:14px; padding:1.1rem .8rem; text-align:center; transition:border-color .15s, transform .15s; }
.cid-stat:hover{ border-color:var(--gold-dim); transform:translateY(-2px); }
.cid-stat i{ font-size:1.4rem; }
.cid-stat-value{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:1.5rem; margin-top:.4rem; color:var(--text); }
.cid-stat-label{ font-family:'IBM Plex Mono',monospace; font-size:.62rem; letter-spacing:.08em; text-transform:uppercase; color:var(--text-dim); margin-top:.15rem; }

.cid-panel{ background:var(--surface); border:1px solid var(--line); border-radius:18px; overflow:hidden; margin-bottom:1.25rem; }
.cid-panel-head{ font-family:'IBM Plex Mono',monospace; font-size:.72rem; letter-spacing:.08em; text-transform:uppercase; color:var(--text-dim); padding:.9rem 1.1rem; border-bottom:1px solid var(--line); display:flex; align-items:center; justify-content:space-between; gap:.5rem; flex-wrap:wrap; }
.cid-panel-head i{ color:var(--gold); }
.cid-panel-head span:first-child{ display:flex; align-items:center; }
.cid-updated{ font-size:.68rem; color:var(--text-dim); }
.cid-cache-badge{ font-family:'IBM Plex Mono',monospace; font-size:.6rem; background:rgba(240,184,75,.15); color:var(--gold); border:1px solid var(--gold-dim); border-radius:10px; padding:.1rem .5rem; margin-left:.35rem; }

.cid-table-shell{ max-height:480px; overflow-y:auto; }
.cid-table{ width:100%; border-collapse:collapse; font-family:'Inter',sans-serif; font-size:.85rem; }
.cid-table thead th{
  position:sticky; top:0; background:var(--surface-raised); font-family:'IBM Plex Mono',monospace; font-size:.62rem;
  letter-spacing:.08em; text-transform:uppercase; color:var(--text-dim); padding:.7rem .8rem; text-align:left; border-bottom:1px solid var(--line); z-index:1;
}
.cid-table thead th.text-end{ text-align:right; }
.cid-table td{ padding:.65rem .8rem; border-bottom:1px solid var(--line); color:var(--text); vertical-align:middle; }
.cid-table tr:hover td{ background:rgba(240,184,75,.04); }
.cid-table tr:last-child td{ border-bottom:none; }
.cid-code-chip{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:.75rem; background:var(--surface-raised); border:1px solid var(--line); border-radius:6px; padding:.15rem .5rem; }
.cid-country{ color:var(--text-dim); font-size:.8rem; }
.cid-rate{ font-family:'IBM Plex Mono',monospace; font-weight:600; text-align:right; }
.cid-change{ font-family:'IBM Plex Mono',monospace; font-size:.78rem; text-align:right; font-weight:600; }
.cid-change--up{ color:var(--up); } .cid-change--down{ color:var(--down); } .cid-change--flat{ color:var(--text-dim); }
.cid-link{
  font-family:'IBM Plex Mono',monospace; font-size:.68rem; color:var(--gold); border:1px solid var(--gold-dim);
  border-radius:16px; padding:.2rem .6rem; text-decoration:none; white-space:nowrap; transition:background .15s;
}
.cid-link:hover{ background:rgba(240,184,75,.1); color:var(--gold); }

.cid-quick-select{
  background:var(--surface-raised); border:1px solid var(--line); color:var(--text); border-radius:8px;
  padding:.35rem .6rem; font-family:'IBM Plex Mono',monospace; font-size:.78rem;
}
.cid-quick-select option{ background:var(--surface); }
</style>
@endpush

@section('content')
<div class="cid-wrap">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
  <div>
    <div class="cid-eyebrow">Currency Terminal</div>
    <h1 class="cid-title">Currency Impact Dashboard</h1>
  </div>
  <form method="GET" class="cid-base-form">
    <label class="cid-base-label mb-0">Base</label>
    <select name="base" class="cid-select" onchange="this.form.submit()">
      @foreach(['USD','EUR','JPY','GBP','CNY','SGD'] as $b)
      <option value="{{ $b }}" {{ $base===$b?'selected':'' }}>{{ $b }}</option>
      @endforeach
    </select>
  </form>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="cid-stat">
      <i class="bi bi-currency-dollar" style="color:var(--gold)"></i>
      <div class="cid-stat-value">{{ $base }}</div>
      <div class="cid-stat-label">Base Currency</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="cid-stat">
      <i class="bi bi-bar-chart" style="color:#5EA8E0"></i>
      <div class="cid-stat-value">{{ count($ratesData['rates']??[]) }}</div>
      <div class="cid-stat-label">Mata Uang Dipantau</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="cid-stat">
      <i class="bi bi-arrow-up" style="color:var(--up)"></i>
      <div class="cid-stat-value" style="color:var(--up)">{{ $currencyRates->where('change_percent','>',0)->count() }}</div>
      <div class="cid-stat-label">Menguat vs Kemarin</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="cid-stat">
      <i class="bi bi-arrow-down" style="color:var(--down)"></i>
      <div class="cid-stat-value" style="color:var(--down)">{{ $currencyRates->where('change_percent','<',0)->count() }}</div>
      <div class="cid-stat-label">Melemah vs Kemarin</div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="cid-panel mb-0">
      <div class="cid-panel-head">
        <span><i class="bi bi-table me-2"></i>Kurs Real-Time (1 {{ $base }})</span>
        <span class="cid-updated">
          {{ $ratesData['last_updated']??now()->format('d M Y H:i') }}
          @if(($ratesData['source']??'')==='database')<span class="cid-cache-badge">CACHE</span>@endif
        </span>
      </div>
      <div class="cid-table-shell">
        <table class="cid-table">
          <thead>
            <tr><th>Mata Uang</th><th>Negara</th><th class="text-end">Kurs</th><th class="text-end">Perubahan</th><th></th></tr>
          </thead>
          <tbody>
            @foreach($ratesData['rates']??[] as $cur=>$rate)
            @php
            $rec=$currencyRates->where('target_currency',$cur)->first();
            $ch=$rec?->change_percent;
            $ti=$ch>0?'↑':($ch<0?'↓':'→');
            $tc=$ch>0?'cid-change--up':($ch<0?'cid-change--down':'cid-change--flat');
            $cnt=$countries->firstWhere('currency_code',$cur);
            @endphp
            <tr>
              <td><span class="cid-code-chip">{{ $cur }}</span></td>
              <td class="cid-country">{{ $cnt?$cnt->flag_emoji.' '.$cnt->name:'—' }}</td>
              <td class="cid-rate">{{ number_format($rate,$rate<1?6:2) }}</td>
              <td class="cid-change {{ $tc }}">{{ $ti }} {{ $ch!==null?number_format(abs($ch),2).'%':'—' }}</td>
              <td>@if($cnt)<a href="{{ route('currency.show',$cnt->code) }}" class="cid-link">Grafik</a>@endif</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="cid-panel">
      <div class="cid-panel-head"><span><i class="bi bi-bar-chart-fill me-2"></i>Perubahan Kurs Terbesar</span></div>
      <div class="p-3"><canvas id="changeChart" height="220"></canvas></div>
    </div>
    <div class="cid-panel mb-0">
      <div class="cid-panel-head">
        <span><i class="bi bi-graph-up me-2"></i>Tren Kurs</span>
        <select id="qCur" class="cid-quick-select" onchange="loadQ()">
          @foreach($countries->whereNotNull('currency_code') as $c)
          @if($c->currency_code!==$base)<option value="{{ $c->code }}">{{ $c->currency_code }}</option>@endif
          @endforeach
        </select>
      </div>
      <div class="p-3"><canvas id="quickChart" height="150"></canvas></div>
    </div>
  </div>
</div>
</div>
@endsection

@push('scripts')
<script>
const gridColor='rgba(255,255,255,.06)', tickColor='#7FA0B8', fontMono={family:'IBM Plex Mono',size:10};

const cr=@json($currencyRates??[]);
const sorted=cr.filter(r=>r.change_percent!==null).sort((a,b)=>Math.abs(b.change_percent)-Math.abs(a.change_percent)).slice(0,10);
new Chart(document.getElementById('changeChart').getContext('2d'),{
  type:'bar',
  data:{labels:sorted.map(r=>r.target_currency),datasets:[{data:sorted.map(r=>r.change_percent),backgroundColor:sorted.map(r=>r.change_percent>0?'rgba(239,91,91,.75)':'rgba(63,208,201,.75)'),borderRadius:4}]},
  options:{responsive:true,plugins:{legend:{display:false}},scales:{
    y:{ticks:{callback:v=>v.toFixed(2)+'%',color:tickColor,font:fontMono},grid:{color:gridColor}},
    x:{ticks:{color:tickColor,font:fontMono},grid:{display:false}}
  }}
});

let qC=null;
function loadQ(){
  const code=document.getElementById('qCur').value;
  if(!code)return;
  showSpinner();
  fetch('/api/v1/currency/'+code).then(r=>r.json()).then(data=>{
    hideSpinner();
    const t=data.trend||{};
    if(qC)qC.destroy();
    const ctx=document.getElementById('quickChart').getContext('2d');
    const grad=ctx.createLinearGradient(0,0,0,150);
    grad.addColorStop(0,'rgba(240,184,75,.25)');
    grad.addColorStop(1,'rgba(240,184,75,0)');
    qC=new Chart(ctx,{
      type:'line',
      data:{labels:t.labels||[],datasets:[{label:(data.target||'')+'/'+data.base,data:t.rates||[],borderColor:'#F0B84B',backgroundColor:grad,tension:.4,fill:true,pointRadius:0}]},
      options:{responsive:true,plugins:{legend:{display:false}},scales:{
        y:{ticks:{maxTicksLimit:5,color:tickColor,font:fontMono},grid:{color:gridColor}},
        x:{ticks:{color:tickColor,font:fontMono},grid:{display:false}}
      }}
    });
  }).catch(()=>hideSpinner());
}
if(document.getElementById('qCur').options.length>0)loadQ();
</script>
@endpush