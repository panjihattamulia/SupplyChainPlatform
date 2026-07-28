<?php $__env->startSection('title','Comparison Result'); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('comparison.index')); ?>">Comparison</a></li>
<li class="breadcrumb-item active">Result</li>
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
.cmp-back{
  font-family:'IBM Plex Mono',monospace; font-size:.75rem; color:var(--text-dim); border:1px solid var(--line);
  border-radius:20px; padding:.45rem .9rem; text-decoration:none; display:inline-flex; align-items:center; gap:.4rem;
  transition:border-color .15s, color .15s;
}
.cmp-back:hover{ border-color:var(--a-color); color:var(--a-color); }

.cmp-card{ background:var(--surface); border:1px solid var(--line); border-radius:16px; padding:1.4rem 1rem; text-align:center; position:relative; }
.cmp-card--a{ border-top:3px solid var(--a-color); }
.cmp-card--b{ border-top:3px solid var(--b-color); }
.cmp-card.is-winner{ box-shadow:0 0 0 1px currentColor, 0 12px 30px -12px currentColor; }
.cmp-flag{ font-size:2.4rem; line-height:1; }
.cmp-name{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.15rem; margin:.35rem 0 .5rem; }
.cmp-score{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:1.9rem; line-height:1; }
.cmp-badge{ font-family:'IBM Plex Mono',monospace; font-size:.72rem; padding:.3rem .65rem; border-radius:20px; border:1px solid; display:inline-block; margin-top:.4rem; }
.cmp-crown{ font-family:'IBM Plex Mono',monospace; font-size:.65rem; letter-spacing:.08em; text-transform:uppercase; margin-top:.5rem; color:var(--a-color); }
.cmp-vs-roundel{
  width:56px; height:56px; border-radius:50%; background:var(--surface-raised); border:1px solid var(--line);
  display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk',sans-serif; font-weight:700;
  color:var(--amber); font-size:.85rem; margin:0 auto;
}

.cmp-duel{ background:var(--surface); border:1px solid var(--line); border-radius:16px; padding:1.2rem 1.4rem; margin-bottom:1.5rem; }
.cmp-duel-head{ display:flex; justify-content:space-between; font-family:'IBM Plex Mono',monospace; font-size:.72rem; color:var(--text-dim); margin-bottom:.6rem; }
.cmp-duel-track{ position:relative; height:14px; background:var(--ink); border-radius:20px; overflow:hidden; display:flex; }
.cmp-duel-fill-a{ background:linear-gradient(90deg,#1c6f68,var(--a-color)); height:100%; }
.cmp-duel-fill-b{ background:linear-gradient(90deg,var(--b-color),#8a2f2f); height:100%; margin-left:auto; }
.cmp-duel-center{ position:absolute; left:50%; top:-3px; bottom:-3px; width:2px; background:var(--text-dim); opacity:.4; }
.cmp-duel-note{ font-family:'Inter',sans-serif; font-size:.72rem; color:var(--text-dim); margin-top:.5rem; text-align:center; }

.cmp-table-panel{ background:var(--surface); border:1px solid var(--line); border-radius:18px; overflow:hidden; margin-bottom:1.5rem; }
.cmp-table-head{ font-family:'IBM Plex Mono',monospace; font-size:.72rem; letter-spacing:.1em; text-transform:uppercase; color:var(--text-dim); padding:.9rem 1.1rem; border-bottom:1px solid var(--line); }
.cmp-table{ width:100%; border-collapse:collapse; font-family:'Inter',sans-serif; font-size:.85rem; }
.cmp-table th{ font-family:'IBM Plex Mono',monospace; font-size:.65rem; letter-spacing:.08em; text-transform:uppercase; color:var(--text-dim); text-align:center; padding:.7rem .5rem; border-bottom:1px solid var(--line); }
.cmp-table th:first-child{ text-align:left; }
.cmp-table td{ padding:.65rem .5rem; text-align:center; border-bottom:1px solid var(--line); color:var(--text); font-family:'IBM Plex Mono',monospace; font-size:.85rem; }
.cmp-table td:first-child{ text-align:left; font-family:'Inter',sans-serif; font-weight:500; }
.cmp-table tr:last-child td{ border-bottom:none; }
.cmp-win-a{ background:var(--a-bg); color:var(--a-color); font-weight:600; }
.cmp-win-b{ background:var(--b-bg); color:var(--b-color); font-weight:600; }
.cmp-win-tag{ font-family:'IBM Plex Mono',monospace; font-size:.65rem; padding:.2rem .5rem; border-radius:12px; background:rgba(63,208,201,.12); color:var(--a-color); }

.cmp-chart-panel{ background:var(--surface); border:1px solid var(--line); border-radius:16px; padding:1rem 1.1rem; height:100%; }
.cmp-chart-head{ font-family:'IBM Plex Mono',monospace; font-size:.68rem; letter-spacing:.1em; text-transform:uppercase; color:var(--text-dim); margin-bottom:.7rem; }

.cmp-verdict{ background:linear-gradient(135deg,#123f38,var(--ink)); border:1px solid var(--a-color); border-radius:18px; padding:1.4rem; }
.cmp-verdict-eyebrow{ font-family:'IBM Plex Mono',monospace; font-size:.68rem; letter-spacing:.14em; text-transform:uppercase; color:var(--a-color); margin-bottom:.5rem; }
.cmp-verdict-flag{ font-size:2.6rem; }
.cmp-verdict-name{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.4rem; margin:.15rem 0 .3rem; }
.cmp-verdict-reason{ color:var(--text-dim); font-size:.85rem; margin:0; }
.cmp-verdict-score{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:1.7rem; color:var(--a-color); text-align:center; }
.cmp-verdict-score-label{ font-family:'IBM Plex Mono',monospace; font-size:.62rem; text-transform:uppercase; color:var(--text-dim); text-align:center; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
$A=$comparison['country_a'];$B=$comparison['country_b'];$W=$comparison['winner_risk'];
$invA = max(0,100-($A['total_score']??0));
$invB = max(0,100-($B['total_score']??0));
$totalInv = ($invA+$invB) ?: 1;
$pctA = round($invA/$totalInv*100,1);
$pctB = round(100-$pctA,1);
$rec = $comparison['recommendation']===$A['country_code'] ? $A : $B;
?>

<div class="cmp-wrap">

<div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
  <div>
    <div class="cmp-eyebrow">Comparison Terminal</div>
    <h1 class="cmp-title">Hasil Perbandingan</h1>
  </div>
  <a href="<?php echo e(route('comparison.index')); ?>" class="cmp-back"><i class="bi bi-arrow-left"></i>Bandingkan Lagi</a>
</div>

<div class="row g-3 mb-3 align-items-center">
  <div class="col-md-5">
    <div class="cmp-card cmp-card--a <?php echo e($W===$A['country_code']?'is-winner':''); ?>" style="color:<?php echo e($W===$A['country_code']?'#3FD0C9':'inherit'); ?>">
      <div class="cmp-flag"><?php echo e($A['flag_emoji']??'🏳️'); ?></div>
      <div class="cmp-name" style="color:var(--text)"><?php echo e($A['country_name']); ?></div>
      <div class="cmp-score"><?php echo e(number_format($A['total_score'],1)); ?></div>
      <span class="cmp-badge" style="color:var(--a-color);border-color:var(--a-color)"><?php echo e($A['risk_label']??''); ?></span>
      <?php if($W===$A['country_code']): ?><div class="cmp-crown">🏆 Direkomendasikan</div><?php endif; ?>
    </div>
  </div>
  <div class="col-md-2 text-center"><div class="cmp-vs-roundel">VS</div></div>
  <div class="col-md-5">
    <div class="cmp-card cmp-card--b <?php echo e($W===$B['country_code']?'is-winner':''); ?>" style="color:<?php echo e($W===$B['country_code']?'#EF5B5B':'inherit'); ?>">
      <div class="cmp-flag"><?php echo e($B['flag_emoji']??'🏳️'); ?></div>
      <div class="cmp-name" style="color:var(--text)"><?php echo e($B['country_name']); ?></div>
      <div class="cmp-score"><?php echo e(number_format($B['total_score'],1)); ?></div>
      <span class="cmp-badge" style="color:var(--b-color);border-color:var(--b-color)"><?php echo e($B['risk_label']??''); ?></span>
      <?php if($W===$B['country_code']): ?><div class="cmp-crown" style="color:var(--b-color)">🏆 Direkomendasikan</div><?php endif; ?>
    </div>
  </div>
</div>

<div class="cmp-duel">
  <div class="cmp-duel-head">
    <span><?php echo e(strtoupper($A['country_name'])); ?></span>
    <span>DUEL METER</span>
    <span><?php echo e(strtoupper($B['country_name'])); ?></span>
  </div>
  <div class="cmp-duel-track">
    <div class="cmp-duel-fill-a" style="width:<?php echo e($pctA); ?>%"></div>
    <div class="cmp-duel-center"></div>
    <div class="cmp-duel-fill-b" style="width:<?php echo e($pctB); ?>%"></div>
  </div>
  <div class="cmp-duel-note">Skor risiko lebih rendah = lebih unggul dalam supply chain</div>
</div>

<div class="cmp-table-panel">
  <div class="cmp-table-head"><i class="bi bi-table me-2" style="color:var(--a-color)"></i>Perbandingan Detail</div>
  <div class="table-responsive">
    <table class="cmp-table">
      <thead>
        <tr><th>Indikator</th><th><?php echo e($A['country_name']); ?></th><th><?php echo e($B['country_name']); ?></th><th>Lebih Baik</th></tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = [
          ['l'=>'🛡️ Risk Score','a'=>number_format($A['total_score'],1),'b'=>number_format($B['total_score'],1),'wa'=>$A['total_score']<=$B['total_score'],'wn'=>$A['total_score']<=$B['total_score']?$A['country_name']:$B['country_name']],
          ['l'=>'🌤️ Weather Risk','a'=>number_format($A['weather_score'],1),'b'=>number_format($B['weather_score'],1),'wa'=>$A['weather_score']<=$B['weather_score'],'wn'=>$A['weather_score']<=$B['weather_score']?$A['country_name']:$B['country_name']],
          ['l'=>'📈 Inflation Risk','a'=>number_format($A['inflation_score'],1),'b'=>number_format($B['inflation_score'],1),'wa'=>$A['inflation_score']<=$B['inflation_score'],'wn'=>$A['inflation_score']<=$B['inflation_score']?$A['country_name']:$B['country_name']],
          ['l'=>'💱 Currency Risk','a'=>number_format($A['currency_score'],1),'b'=>number_format($B['currency_score'],1),'wa'=>$A['currency_score']<=$B['currency_score'],'wn'=>$A['currency_score']<=$B['currency_score']?$A['country_name']:$B['country_name']],
          ['l'=>'📰 News Risk','a'=>number_format($A['news_sentiment_score'],1),'b'=>number_format($B['news_sentiment_score'],1),'wa'=>$A['news_sentiment_score']<=$B['news_sentiment_score'],'wn'=>$A['news_sentiment_score']<=$B['news_sentiment_score']?$A['country_name']:$B['country_name']],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td><?php echo e($r['l']); ?></td>
          <td class="<?php echo e($r['wa']?'cmp-win-a':''); ?>"><?php echo e($r['a']); ?></td>
          <td class="<?php echo e(!$r['wa']?'cmp-win-b':''); ?>"><?php echo e($r['b']); ?></td>
          <td><span class="cmp-win-tag"><?php echo e($r['wn']); ?></span></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-md-6">
    <div class="cmp-chart-panel">
      <div class="cmp-chart-head">Radar Chart</div>
      <canvas id="rC" height="280"></canvas>
    </div>
  </div>
  <div class="col-md-6">
    <div class="cmp-chart-panel">
      <div class="cmp-chart-head">Risk Bar Chart</div>
      <canvas id="bC" height="280"></canvas>
    </div>
  </div>
</div>

<div class="cmp-verdict">
  <div class="cmp-verdict-eyebrow"><i class="bi bi-trophy me-1"></i>Rekomendasi Supply Chain</div>
  <div class="row align-items-center g-3">
    <div class="col-auto"><div class="cmp-verdict-flag"><?php echo e($rec['flag_emoji']??'🏳️'); ?></div></div>
    <div class="col">
      <div class="cmp-verdict-name"><?php echo e($rec['country_name']); ?></div>
      <p class="cmp-verdict-reason"><?php echo e($comparison['recommendation_reason']); ?></p>
    </div>
    <div class="col-auto">
      <div class="cmp-verdict-score"><?php echo e(number_format($rec['total_score'],1)); ?></div>
      <div class="cmp-verdict-score-label">Risk Score</div>
    </div>
  </div>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const A=<?php echo json_encode($comparison['country_a'], 15, 512) ?>,B=<?php echo json_encode($comparison['country_b'], 15, 512) ?>;
const lbls=['Risk','Weather','Inflation','Currency','News'];
const dA=[A.total_score,A.weather_score,A.inflation_score,A.currency_score,A.news_sentiment_score];
const dB=[B.total_score,B.weather_score,B.inflation_score,B.currency_score,B.news_sentiment_score];
const gridColor='rgba(255,255,255,.06)', tickColor='#7FA0B8', fontMono={family:'IBM Plex Mono',size:10};

new Chart(document.getElementById('rC').getContext('2d'),{
  type:'radar',
  data:{labels:lbls,datasets:[
    {label:A.country_name,data:dA,borderColor:'#3FD0C9',backgroundColor:'rgba(63,208,201,.15)',pointBackgroundColor:'#3FD0C9'},
    {label:B.country_name,data:dB,borderColor:'#EF5B5B',backgroundColor:'rgba(239,91,91,.15)',pointBackgroundColor:'#EF5B5B'}
  ]},
  options:{responsive:true,scales:{r:{min:0,max:100,ticks:{stepSize:20,color:tickColor,backdropColor:'transparent',font:fontMono},grid:{color:gridColor},angleLines:{color:gridColor},pointLabels:{color:'#EAF2F6',font:{family:'Inter',size:11}}}},plugins:{legend:{position:'bottom',labels:{color:tickColor,font:{family:'Inter',size:11}}}}}
});

new Chart(document.getElementById('bC').getContext('2d'),{
  type:'bar',
  data:{labels:lbls,datasets:[
    {label:A.country_name,data:dA,backgroundColor:'rgba(63,208,201,.75)',borderRadius:4},
    {label:B.country_name,data:dB,backgroundColor:'rgba(239,91,91,.75)',borderRadius:4}
  ]},
  options:{responsive:true,plugins:{legend:{position:'bottom',labels:{color:tickColor,font:{family:'Inter',size:11}}}},scales:{
    y:{max:100,min:0,ticks:{color:tickColor,font:fontMono},grid:{color:gridColor}},
    x:{ticks:{color:tickColor,font:fontMono},grid:{display:false}}
  }}
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\Global Supply\supply-chain-platform\resources\views/comparison/result.blade.php ENDPATH**/ ?>