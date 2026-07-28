<?php $__env->startSection('title','Country Comparison Engine'); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Comparison</li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#0A1E2E; --surface:#102A3D; --surface-raised:#16374C; --line:#20415A;
  --text:#EAF2F6; --text-dim:#7FA0B8;
  --a-color:#3FD0C9; --a-bg:rgba(63,208,201,.10);
  --b-color:#EF5B5B; --b-bg:rgba(239,91,91,.10);
  --amber:#F0A947;
}
.cmp-wrap{ font-family:'Inter',sans-serif; color:var(--text); }
.cmp-eyebrow{ font-family:'IBM Plex Mono',monospace; font-size:.68rem; letter-spacing:.18em; text-transform:uppercase; color:var(--a-color); display:flex; align-items:center; gap:.5rem; margin-bottom:.3rem; }
.cmp-eyebrow::before{ content:''; width:6px; height:6px; border-radius:50%; background:var(--a-color); box-shadow:0 0 0 3px rgba(63,208,201,.25); }
.cmp-title{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.7rem; margin:0; }
.cmp-sub{ font-family:'IBM Plex Mono',monospace; font-size:.72rem; color:var(--text-dim); }

.cmp-panel{ background:radial-gradient(circle at 15% 0%,#153a52 0%,var(--ink) 60%); border:1px solid var(--line); border-radius:18px; padding:1.4rem; margin-bottom:1.5rem; }
.cmp-label{ font-family:'IBM Plex Mono',monospace; font-size:.66rem; letter-spacing:.1em; text-transform:uppercase; color:var(--text-dim); margin-bottom:.4rem; display:block; }
.cmp-select{
  width:100%; background:var(--surface); border:1px solid var(--line); color:var(--text);
  border-radius:10px; padding:.6rem .8rem; font-family:'Inter',sans-serif; font-size:.9rem;
}
.cmp-select:focus{ outline:none; border-color:var(--a-color); box-shadow:0 0 0 3px rgba(63,208,201,.15); }
.cmp-select option{ background:var(--surface); }
.cmp-vs-mini{ width:100%; height:44px; border-radius:10px; background:var(--surface); border:1px solid var(--line); display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk',sans-serif; font-weight:700; color:var(--amber); font-size:.85rem; }
.cmp-btn{
  width:100%; background:var(--a-color); border:none; color:#04211E; font-family:'Space Grotesk',sans-serif;
  font-weight:700; border-radius:10px; padding:.62rem; font-size:.9rem; transition:filter .15s, transform .15s;
}
.cmp-btn:hover{ filter:brightness(1.08); transform:translateY(-1px); }

/* Result cards */
.cmp-card{ background:var(--surface); border:1px solid var(--line); border-radius:16px; padding:1.4rem 1rem; text-align:center; transition:border-color .2s, box-shadow .2s; position:relative; }
.cmp-card--a{ border-top:3px solid var(--a-color); }
.cmp-card--b{ border-top:3px solid var(--b-color); }
.cmp-card.is-winner{ box-shadow:0 0 0 1px currentColor, 0 12px 30px -12px currentColor; }
.cmp-flag{ font-size:2.4rem; line-height:1; }
.cmp-name{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.15rem; margin:.35rem 0 .5rem; }
.cmp-vs-roundel{
  width:56px; height:56px; border-radius:50%; background:var(--surface-raised); border:1px solid var(--line);
  display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk',sans-serif; font-weight:700;
  color:var(--amber); font-size:.85rem; margin:0 auto;
}
.cmp-badge{ font-family:'IBM Plex Mono',monospace; font-size:.72rem; padding:.3rem .65rem; border-radius:20px; border:1px solid; display:inline-block; }
.cmp-crown{ font-family:'IBM Plex Mono',monospace; font-size:.65rem; letter-spacing:.08em; text-transform:uppercase; margin-top:.5rem; color:var(--a-color); }

/* Duel meter */
.cmp-duel{ background:var(--surface); border:1px solid var(--line); border-radius:16px; padding:1.2rem 1.4rem; margin-bottom:1.5rem; }
.cmp-duel-head{ display:flex; justify-content:space-between; font-family:'IBM Plex Mono',monospace; font-size:.72rem; color:var(--text-dim); margin-bottom:.6rem; }
.cmp-duel-track{ position:relative; height:14px; background:var(--ink); border-radius:20px; overflow:hidden; display:flex; }
.cmp-duel-fill-a{ background:linear-gradient(90deg,#1c6f68,var(--a-color)); height:100%; transition:width .6s ease; }
.cmp-duel-fill-b{ background:linear-gradient(90deg,var(--b-color),#8a2f2f); height:100%; transition:width .6s ease; margin-left:auto; }
.cmp-duel-center{ position:absolute; left:50%; top:-3px; bottom:-3px; width:2px; background:var(--text-dim); opacity:.4; }
.cmp-duel-note{ font-family:'Inter',sans-serif; font-size:.72rem; color:var(--text-dim); margin-top:.5rem; text-align:center; }

/* Table */
.cmp-table-panel{ background:var(--surface); border:1px solid var(--line); border-radius:18px; overflow:hidden; margin-bottom:1.5rem; }
.cmp-table-head{ font-family:'IBM Plex Mono',monospace; font-size:.72rem; letter-spacing:.1em; text-transform:uppercase; color:var(--text-dim); padding:.9rem 1.1rem; border-bottom:1px solid var(--line); }
.cmp-table{ width:100%; border-collapse:collapse; font-family:'Inter',sans-serif; font-size:.85rem; }
.cmp-table th{ font-family:'IBM Plex Mono',monospace; font-size:.65rem; letter-spacing:.08em; text-transform:uppercase; color:var(--text-dim); text-align:center; padding:.7rem .5rem; border-bottom:1px solid var(--line); }
.cmp-table th:first-child{ text-align:left; }
.cmp-table td{ padding:.65rem .5rem; text-align:center; border-bottom:1px solid var(--line); color:var(--text); font-family:'IBM Plex Mono',monospace; font-size:.85rem; }
.cmp-table td:first-child{ text-align:left; font-family:'Inter',sans-serif; font-weight:500; }
.cmp-table tr:last-child td{ border-bottom:none; }
.cmp-win-a{ background:var(--a-bg); color:var(--a-color); font-weight:600; position:relative; }
.cmp-win-b{ background:var(--b-bg); color:var(--b-color); font-weight:600; }
.cmp-win-tag{ font-family:'IBM Plex Mono',monospace; font-size:.65rem; padding:.2rem .5rem; border-radius:12px; background:rgba(63,208,201,.12); color:var(--a-color); }

/* Charts */
.cmp-chart-panel{ background:var(--surface); border:1px solid var(--line); border-radius:16px; padding:1rem 1.1rem; height:100%; }
.cmp-chart-head{ font-family:'IBM Plex Mono',monospace; font-size:.68rem; letter-spacing:.1em; text-transform:uppercase; color:var(--text-dim); margin-bottom:.7rem; }

/* Verdict */
.cmp-verdict{ background:linear-gradient(135deg,#123f38,var(--ink)); border:1px solid var(--a-color); border-radius:18px; padding:1.4rem; margin-bottom:1.5rem; }
.cmp-verdict-eyebrow{ font-family:'IBM Plex Mono',monospace; font-size:.68rem; letter-spacing:.14em; text-transform:uppercase; color:var(--a-color); margin-bottom:.5rem; }
.cmp-verdict-flag{ font-size:2.6rem; }
.cmp-verdict-name{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.4rem; margin:.15rem 0 .3rem; }
.cmp-verdict-reason{ color:var(--text-dim); font-size:.85rem; margin:0; }
.cmp-verdict-score{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:1.7rem; color:var(--a-color); text-align:center; }
.cmp-verdict-score-label{ font-family:'IBM Plex Mono',monospace; font-size:.62rem; text-transform:uppercase; color:var(--text-dim); text-align:center; }

/* History */
.cmp-history{ background:var(--surface); border:1px solid var(--line); border-radius:16px; overflow:hidden; }
.cmp-history-head{ font-family:'IBM Plex Mono',monospace; font-size:.68rem; letter-spacing:.1em; text-transform:uppercase; color:var(--text-dim); padding:.8rem 1.1rem; border-bottom:1px solid var(--line); }
.cmp-history table{ width:100%; font-family:'Inter',sans-serif; font-size:.82rem; border-collapse:collapse; }
.cmp-history td{ padding:.55rem .8rem; border-bottom:1px solid var(--line); color:var(--text); }
.cmp-history tr:last-child td{ border-bottom:none; }
.cmp-history .replay-btn{
  font-family:'IBM Plex Mono',monospace; font-size:.68rem; background:transparent; color:var(--a-color);
  border:1px solid var(--a-color); border-radius:20px; padding:.2rem .6rem; cursor:pointer; transition:background .15s;
}
.cmp-history .replay-btn:hover{ background:rgba(63,208,201,.1); }
.cmp-time{ color:var(--text-dim); font-family:'IBM Plex Mono',monospace; font-size:.72rem; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="cmp-wrap">

<div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
  <div>
    <div class="cmp-eyebrow">Comparison Terminal</div>
    <h1 class="cmp-title">Country Comparison Engine</h1>
  </div>
  <div class="cmp-sub">GDP · INFLATION · RISK · WEATHER · CURRENCY</div>
</div>

<div class="cmp-panel">
  <form id="cmpForm">
    <?php echo csrf_field(); ?>
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <label class="cmp-label">Negara A</label>
        <select name="country_a" id="cA" class="cmp-select" required>
          <option value="">Pilih Negara A...</option>
          <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($c->code); ?>" <?php echo e(request('a')===$c->code?'selected':''); ?>><?php echo e($c->flag_emoji); ?> <?php echo e($c->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="col-md-1"><div class="cmp-vs-mini">VS</div></div>
      <div class="col-md-4">
        <label class="cmp-label">Negara B</label>
        <select name="country_b" id="cB" class="cmp-select" required>
          <option value="">Pilih Negara B...</option>
          <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($c->code); ?>"><?php echo e($c->flag_emoji); ?> <?php echo e($c->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="col-md-3">
        <button type="submit" class="cmp-btn"><i class="bi bi-search me-2"></i>Bandingkan</button>
      </div>
    </div>
  </form>
</div>

<div id="cmpResult" style="display:none">

  <div class="row g-3 mb-3 align-items-center">
    <div class="col-md-5">
      <div class="cmp-card cmp-card--a" id="cardA">
        <div class="cmp-flag" id="flagA">🏳️</div>
        <div class="cmp-name" id="nameA">—</div>
        <div id="scoreA"></div>
      </div>
    </div>
    <div class="col-md-2 text-center">
      <div class="cmp-vs-roundel">VS</div>
    </div>
    <div class="col-md-5">
      <div class="cmp-card cmp-card--b" id="cardB">
        <div class="cmp-flag" id="flagB">🏳️</div>
        <div class="cmp-name" id="nameB">—</div>
        <div id="scoreB"></div>
      </div>
    </div>
  </div>

  <div class="cmp-duel">
    <div class="cmp-duel-head">
      <span id="duelLabelA">NEGARA A</span>
      <span>DUEL METER</span>
      <span id="duelLabelB">NEGARA B</span>
    </div>
    <div class="cmp-duel-track">
      <div class="cmp-duel-fill-a" id="duelA" style="width:50%"></div>
      <div class="cmp-duel-center"></div>
      <div class="cmp-duel-fill-b" id="duelB" style="width:50%"></div>
    </div>
    <div class="cmp-duel-note">Skor risiko lebih rendah = lebih unggul dalam supply chain</div>
  </div>

  <div class="cmp-table-panel">
    <div class="cmp-table-head"><i class="bi bi-table me-2" style="color:var(--a-color)"></i>Perbandingan Detail</div>
    <div class="table-responsive">
      <table class="cmp-table">
        <thead>
          <tr><th>Indikator</th><th id="thA">Negara A</th><th id="thB">Negara B</th><th>Lebih Baik</th></tr>
        </thead>
        <tbody id="cmpBody"></tbody>
      </table>
    </div>
  </div>

  <div class="row g-3 mb-3">
    <div class="col-md-6">
      <div class="cmp-chart-panel">
        <div class="cmp-chart-head">Radar Chart</div>
        <canvas id="cmpRadar" height="280"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="cmp-chart-panel">
        <div class="cmp-chart-head">Risk Components</div>
        <canvas id="cmpBar" height="280"></canvas>
      </div>
    </div>
  </div>

  <div class="cmp-verdict">
    <div class="cmp-verdict-eyebrow"><i class="bi bi-trophy me-1"></i>Rekomendasi Supply Chain</div>
    <div class="row align-items-center g-3">
      <div class="col-auto"><div class="cmp-verdict-flag" id="recFlag">🏳️</div></div>
      <div class="col">
        <div class="cmp-verdict-name" id="recName">—</div>
        <p class="cmp-verdict-reason" id="recReason">—</p>
      </div>
      <div class="col-auto">
        <div class="cmp-verdict-score" id="recScore">—</div>
        <div class="cmp-verdict-score-label">Risk Score</div>
      </div>
    </div>
  </div>
</div>

<?php if($recent->isNotEmpty()): ?>
<div class="cmp-history mt-4">
  <div class="cmp-history-head"><i class="bi bi-clock-history me-2"></i>Perbandingan Terakhir</div>
  <table>
    <tbody>
      <?php $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $snap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($snap->countryA->flag_emoji??''); ?> <?php echo e($snap->countryA->name??$snap->country_a); ?></td>
        <td style="text-align:center">⚖️</td>
        <td><?php echo e($snap->countryB->flag_emoji??''); ?> <?php echo e($snap->countryB->name??$snap->country_b); ?></td>
        <td><button class="replay-btn" onclick="replay('<?php echo e($snap->country_a); ?>','<?php echo e($snap->country_b); ?>')"><?php echo e($snap->recommendation); ?></button></td>
        <td class="cmp-time"><?php echo e($snap->created_at->diffForHumans()); ?></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
</div>
<?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let rI=null,bI=null;
document.getElementById('cmpForm').addEventListener('submit',e=>{
  e.preventDefault();
  const a=document.getElementById('cA').value,b=document.getElementById('cB').value;
  if(!a||!b||a===b){alert('Pilih dua negara berbeda!');return;}
  runCmp(a,b);
});
function replay(a,b){document.getElementById('cA').value=a;document.getElementById('cB').value=b;runCmp(a,b);}
function runCmp(a,b){
  showSpinner();
  fetch('<?php echo e(route('comparison.compare')); ?>',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF_TOKEN,'Accept':'application/json'},body:JSON.stringify({country_a:a,country_b:b})})
  .then(r=>r.json()).then(d=>{hideSpinner();renderCmp(d);}).catch(e=>{hideSpinner();console.error(e);alert('Error. Coba lagi.');});
}
function renderCmp(d){
  const A=d.country_a,B=d.country_b,W=d.winner_risk;
  document.getElementById('flagA').textContent=A.flag_emoji||'🏳️';
  document.getElementById('nameA').textContent=A.country_name;
  document.getElementById('flagB').textContent=B.flag_emoji||'🏳️';
  document.getElementById('nameB').textContent=B.country_name;
  document.getElementById('thA').textContent=A.country_name;
  document.getElementById('thB').textContent=B.country_name;
  document.getElementById('duelLabelA').textContent=A.country_name.toUpperCase();
  document.getElementById('duelLabelB').textContent=B.country_name.toUpperCase();

  const cardA=document.getElementById('cardA'), cardB=document.getElementById('cardB');
  cardA.classList.toggle('is-winner', W===A.country_code);
  cardB.classList.toggle('is-winner', W===B.country_code);
  cardA.style.color = W===A.country_code ? '#3FD0C9' : '';
  cardB.style.color = W===B.country_code ? '#EF5B5B' : '';

  const mkScore=(x,isWinner,color)=>`
    <span class="cmp-badge" style="color:${color};border-color:${color}">${x.risk_label||''} · ${(x.total_score||0).toFixed(1)}</span>
    ${isWinner?'<div class="cmp-crown">🏆 Direkomendasikan</div>':''}`;
  document.getElementById('scoreA').innerHTML=mkScore(A,W===A.country_code,'#3FD0C9');
  document.getElementById('scoreB').innerHTML=mkScore(B,W===B.country_code,'#EF5B5B');

  // Duel meter: skor lebih rendah = lebih dominan
  const invA = Math.max(0,100-(A.total_score||0));
  const invB = Math.max(0,100-(B.total_score||0));
  const totalInv = (invA+invB)||1;
  const pctA = (invA/totalInv*100).toFixed(1);
  const pctB = (100-pctA).toFixed(1);
  document.getElementById('duelA').style.width = pctA+'%';
  document.getElementById('duelB').style.width = pctB+'%';

  const econA=A.economic||{},econB=B.economic||{};
  const fmtGdp=v=>!v?'N/A':v>=1e12?'$'+(v/1e12).toFixed(2)+'T':v>=1e9?'$'+(v/1e9).toFixed(2)+'B':'$'+v.toLocaleString();
  const rows=[
    {l:'🛡️ Risk Score',a:(A.total_score||0).toFixed(1),b:(B.total_score||0).toFixed(1),wa:A.total_score<=B.total_score,wn:A.total_score<=B.total_score?A.country_name:B.country_name},
    {l:'🌤️ Weather Risk',a:(A.weather_score||0).toFixed(1),b:(B.weather_score||0).toFixed(1),wa:A.weather_score<=B.weather_score,wn:A.weather_score<=B.weather_score?A.country_name:B.country_name},
    {l:'📈 Inflation Risk',a:(A.inflation_score||0).toFixed(1),b:(B.inflation_score||0).toFixed(1),wa:A.inflation_score<=B.inflation_score,wn:A.inflation_score<=B.inflation_score?A.country_name:B.country_name},
    {l:'💱 Currency Risk',a:(A.currency_score||0).toFixed(1),b:(B.currency_score||0).toFixed(1),wa:A.currency_score<=B.currency_score,wn:A.currency_score<=B.currency_score?A.country_name:B.country_name},
    {l:'📰 News Risk',a:(A.news_sentiment_score||0).toFixed(1),b:(B.news_sentiment_score||0).toFixed(1),wa:A.news_sentiment_score<=B.news_sentiment_score,wn:A.news_sentiment_score<=B.news_sentiment_score?A.country_name:B.country_name},
    {l:'💰 GDP',a:fmtGdp(econA.gdp),b:fmtGdp(econB.gdp),wa:(econA.gdp||0)>=(econB.gdp||0),wn:(econA.gdp||0)>=(econB.gdp||0)?A.country_name:B.country_name},
    {l:'📊 Inflasi (%)',a:econA.inflation?econA.inflation.toFixed(2)+'%':'N/A',b:econB.inflation?econB.inflation.toFixed(2)+'%':'N/A',wa:(econA.inflation||99)<=(econB.inflation||99),wn:(econA.inflation||99)<=(econB.inflation||99)?A.country_name:B.country_name},
  ];
  const tb=document.getElementById('cmpBody');tb.innerHTML='';
  rows.forEach(r=>{
    tb.innerHTML+=`<tr><td>${r.l}</td><td class="${r.wa?'cmp-win-a':''}">${r.a}</td><td class="${!r.wa?'cmp-win-b':''}">${r.b}</td><td><span class="cmp-win-tag">${r.wn}</span></td></tr>`;
  });

  const rec=d.recommendation===A.country_code?A:B;
  document.getElementById('recFlag').textContent=rec.flag_emoji||'🏳️';
  document.getElementById('recName').textContent=rec.country_name;
  document.getElementById('recScore').textContent=(rec.total_score||0).toFixed(1);
  document.getElementById('recReason').textContent=d.recommendation_reason;

  const gridColor='rgba(255,255,255,.06)', tickColor='#7FA0B8', fontMono={family:'IBM Plex Mono',size:10};

  if(rI)rI.destroy();
  rI=new Chart(document.getElementById('cmpRadar').getContext('2d'),{
    type:'radar',
    data:{labels:['Risk','Weather','Inflation','Currency','News'],datasets:[
      {label:A.country_name,data:[A.total_score,A.weather_score,A.inflation_score,A.currency_score,A.news_sentiment_score],borderColor:'#3FD0C9',backgroundColor:'rgba(63,208,201,.15)',pointBackgroundColor:'#3FD0C9'},
      {label:B.country_name,data:[B.total_score,B.weather_score,B.inflation_score,B.currency_score,B.news_sentiment_score],borderColor:'#EF5B5B',backgroundColor:'rgba(239,91,91,.15)',pointBackgroundColor:'#EF5B5B'}
    ]},
    options:{responsive:true,scales:{r:{min:0,max:100,ticks:{stepSize:20,color:tickColor,backdropColor:'transparent',font:fontMono},grid:{color:gridColor},angleLines:{color:gridColor},pointLabels:{color:'#EAF2F6',font:{family:'Inter',size:11}}}},plugins:{legend:{position:'bottom',labels:{color:tickColor,font:{family:'Inter',size:11}}}}}
  });

  if(bI)bI.destroy();
  bI=new Chart(document.getElementById('cmpBar').getContext('2d'),{
    type:'bar',
    data:{labels:['Total','Weather','Inflation','Currency','News'],datasets:[
      {label:A.country_name,data:[A.total_score,A.weather_score,A.inflation_score,A.currency_score,A.news_sentiment_score],backgroundColor:'rgba(63,208,201,.75)',borderRadius:4},
      {label:B.country_name,data:[B.total_score,B.weather_score,B.inflation_score,B.currency_score,B.news_sentiment_score],backgroundColor:'rgba(239,91,91,.75)',borderRadius:4}
    ]},
    options:{responsive:true,plugins:{legend:{position:'bottom',labels:{color:tickColor,font:{family:'Inter',size:11}}}},scales:{
      y:{max:100,min:0,ticks:{color:tickColor,font:fontMono},grid:{color:gridColor}},
      x:{ticks:{color:tickColor,font:fontMono},grid:{display:false}}
    }}
  });

  document.getElementById('cmpResult').style.display='';
  document.getElementById('cmpResult').scrollIntoView({behavior:'smooth'});
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\Global Supply\supply-chain-platform\resources\views/comparison/index.blade.php ENDPATH**/ ?>