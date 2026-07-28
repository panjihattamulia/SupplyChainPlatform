<?php $__env->startSection('title','Kurs — '.$country->name); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('currency.index')); ?>">Currency</a></li>
<li class="breadcrumb-item active"><?php echo e($country->name); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#0A1E2E; --surface:#102A3D; --surface-raised:#16374C; --line:#20415A;
  --text:#EAF2F6; --text-dim:#7FA0B8;
  --gold:#F0B84B; --gold-dim:#C99A3E;
  --up:#EF5B5B; --down:#3FD0C9;
}
.cur-wrap{ font-family:'Inter',sans-serif; color:var(--text); }
.cur-eyebrow{ font-family:'IBM Plex Mono',monospace; font-size:.68rem; letter-spacing:.18em; text-transform:uppercase; color:var(--gold); display:flex; align-items:center; gap:.5rem; margin-bottom:.3rem; }
.cur-eyebrow::before{ content:''; width:6px; height:6px; border-radius:50%; background:var(--gold); box-shadow:0 0 0 3px rgba(240,184,75,.25); }

/* Ticker card */
.cur-ticker{
  position:relative; overflow:hidden; background:radial-gradient(circle at 20% 0%,#2a2412 0%,var(--ink) 60%);
  border:1px solid var(--line); border-radius:18px; padding:2rem 1.5rem 1.6rem; text-align:center;
}
.cur-ticker-bg{ position:absolute; inset:0; opacity:.15; pointer-events:none; }
.cur-flag{ font-size:2.4rem; }
.cur-country{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.3rem; margin:.25rem 0 .5rem; }
.cur-pair{ font-family:'IBM Plex Mono',monospace; font-size:.72rem; color:var(--text-dim); letter-spacing:.05em; }
.cur-rate{
  font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:3rem; line-height:1; color:var(--gold);
  margin:.6rem 0 .2rem; letter-spacing:-.02em;
}
.cur-rate-sub{ font-family:'IBM Plex Mono',monospace; font-size:.78rem; color:var(--text-dim); }

.cur-stat-strip{ margin-top:1.3rem; background:var(--surface); border:1px solid var(--line); border-radius:12px; padding:.9rem; }
.cur-stat-row{ display:flex; justify-content:space-around; text-align:center; }
.cur-stat-label{ font-family:'IBM Plex Mono',monospace; font-size:.6rem; letter-spacing:.1em; text-transform:uppercase; color:var(--text-dim); }
.cur-stat-value{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:1.05rem; margin-top:.2rem; }
.cur-trend-tag{
  display:inline-flex; align-items:center; gap:.3rem; font-family:'IBM Plex Mono',monospace; font-size:.95rem; font-weight:600;
}
.cur-trend-up{ color:var(--up); } .cur-trend-down{ color:var(--down); } .cur-trend-flat{ color:var(--text-dim); }

.cur-risk-bar-shell{ margin-top:.9rem; }
.cur-risk-head{ display:flex; justify-content:space-between; font-family:'IBM Plex Mono',monospace; font-size:.62rem; color:var(--text-dim); text-transform:uppercase; letter-spacing:.08em; margin-bottom:.35rem; }
.cur-risk-track{ height:8px; background:var(--ink); border-radius:20px; overflow:hidden; border:1px solid var(--line); }
.cur-risk-fill{ height:100%; border-radius:20px; transition:width .6s ease; }

.cur-info-card{ background:var(--surface); border:1px solid var(--line); border-radius:16px; padding:1.2rem; margin-top:1.25rem; }
.cur-info-row{ display:flex; justify-content:space-between; padding:.5rem 0; border-bottom:1px solid var(--line); font-size:.85rem; }
.cur-info-row:last-child{ border-bottom:none; }
.cur-info-label{ color:var(--text-dim); font-family:'IBM Plex Mono',monospace; font-size:.72rem; text-transform:uppercase; letter-spacing:.05em; }
.cur-info-value{ font-weight:500; color:var(--text); }
.cur-btn{
  display:flex; align-items:center; justify-content:center; gap:.5rem; width:100%; margin-top:1rem;
  background:transparent; border:1px solid var(--gold-dim); color:var(--gold); font-family:'Inter',sans-serif;
  font-weight:500; font-size:.85rem; border-radius:10px; padding:.6rem; text-decoration:none; transition:background .15s, color .15s;
}
.cur-btn:hover{ background:rgba(240,184,75,.1); color:var(--gold); }

.cur-panel{ background:var(--surface); border:1px solid var(--line); border-radius:18px; margin-bottom:1.25rem; overflow:hidden; }
.cur-panel-head{ font-family:'IBM Plex Mono',monospace; font-size:.72rem; letter-spacing:.1em; text-transform:uppercase; color:var(--text-dim); padding:.9rem 1.1rem; border-bottom:1px solid var(--line); display:flex; align-items:center; gap:.5rem; }
.cur-panel-head i{ color:var(--gold); }
.cur-panel-body{ padding:1.1rem; }

.cur-metric{ background:var(--surface); border:1px solid var(--line); border-radius:12px; padding:.9rem .6rem; text-align:center; }
.cur-metric-label{ font-family:'IBM Plex Mono',monospace; font-size:.62rem; letter-spacing:.08em; text-transform:uppercase; color:var(--text-dim); }
.cur-metric-value{ font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:1.15rem; margin-top:.3rem; }

.cur-empty{ text-align:center; color:var(--text-dim); padding:2.5rem 1rem; }
.cur-empty i{ font-size:2.2rem; opacity:.3; display:block; margin-bottom:.6rem; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
  $trendIcon = $rateRecord->trend_icon ?? '';
  $changeVal = $rateRecord->change_percent ?? null;
  $trendClass = is_null($changeVal) ? 'cur-trend-flat' : ($changeVal > 0 ? 'cur-trend-up' : ($changeVal < 0 ? 'cur-trend-down' : 'cur-trend-flat'));
  $riskScore = $rateRecord->currency_risk_score ?? 0;
  [$riskColor,$riskLabel] = match(true){
    $riskScore<=30 => ['var(--down)','Low'],
    $riskScore<=60 => ['var(--gold)','Medium'],
    default => ['var(--up)','High'],
  };
?>
<div class="cur-wrap">
<div class="row g-4">
  <div class="col-lg-4">

    <div class="cur-ticker">
      <div class="cur-eyebrow" style="justify-content:center">Exchange Rate</div>
      <div class="cur-flag"><?php echo e($country->flag_emoji??'🏳️'); ?></div>
      <div class="cur-country"><?php echo e($country->name); ?></div>
      <div class="cur-pair">1 <?php echo e($base); ?> = ? <?php echo e($target); ?></div>
      <div class="cur-rate"><?php echo e($currentRate?number_format($currentRate,$currentRate<1?6:2):'—'); ?></div>
      <div class="cur-rate-sub"><?php echo e($target); ?> · <?php echo e($country->currency_name); ?></div>

      <?php if($rateRecord): ?>
      <div class="cur-stat-strip">
        <div class="cur-stat-row">
          <div>
            <div class="cur-stat-label">Kemarin</div>
            <div class="cur-stat-value"><?php echo e($rateRecord->rate_previous?number_format($rateRecord->rate_previous,2):'—'); ?></div>
          </div>
          <div>
            <div class="cur-stat-label">Perubahan</div>
            <div class="cur-trend-tag <?php echo e($trendClass); ?>"><?php echo e($trendIcon); ?> <?php echo e(!is_null($changeVal)?number_format(abs($changeVal),2).'%':'—'); ?></div>
          </div>
        </div>
        <div class="cur-risk-bar-shell">
          <div class="cur-risk-head">
            <span>Currency Risk</span>
            <span style="color:<?php echo e($riskColor); ?>"><?php echo e(number_format($riskScore,1)); ?>/100 · <?php echo e($riskLabel); ?></span>
          </div>
          <div class="cur-risk-track">
            <div class="cur-risk-fill" style="width:<?php echo e(min(100,$riskScore)); ?>%;background:<?php echo e($riskColor); ?>"></div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <div class="cur-info-card">
      <div class="cur-info-row"><span class="cur-info-label">Negara</span><span class="cur-info-value"><?php echo e($country->name); ?></span></div>
      <div class="cur-info-row"><span class="cur-info-label">Kode</span><span class="cur-info-value"><?php echo e($target); ?></span></div>
      <div class="cur-info-row"><span class="cur-info-label">Nama</span><span class="cur-info-value"><?php echo e($country->currency_name); ?></span></div>
      <div class="cur-info-row"><span class="cur-info-label">Base</span><span class="cur-info-value"><?php echo e($base); ?></span></div>
      <a href="<?php echo e(route('countries.show',$country->code)); ?>" class="cur-btn">
        <i class="bi bi-globe"></i>Country Dashboard
      </a>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="cur-panel">
      <div class="cur-panel-head"><i class="bi bi-graph-up"></i>Tren Kurs 30 Hari — <?php echo e($base); ?>/<?php echo e($target); ?></div>
      <div class="cur-panel-body">
        <canvas id="trendChart" height="240"></canvas>
      </div>
    </div>

    <?php if(!empty($trendData['rates'])): ?>
    <?php $r=$trendData['rates'];$mn=min($r);$mx=max($r);$avg=array_sum($r)/count($r);$lt=end($r);$ft=reset($r);$chg=$ft>0?(($lt-$ft)/$ft)*100:0; ?>
    <div class="row g-3">
      <div class="col-6 col-md-3"><div class="cur-metric"><div class="cur-metric-label">Tertinggi</div><div class="cur-metric-value"><?php echo e(number_format($mx,2)); ?></div></div></div>
      <div class="col-6 col-md-3"><div class="cur-metric"><div class="cur-metric-label">Terendah</div><div class="cur-metric-value"><?php echo e(number_format($mn,2)); ?></div></div></div>
      <div class="col-6 col-md-3"><div class="cur-metric"><div class="cur-metric-label">Rata-rata</div><div class="cur-metric-value"><?php echo e(number_format($avg,2)); ?></div></div></div>
      <div class="col-6 col-md-3"><div class="cur-metric">
        <div class="cur-metric-label">Perubahan 30h</div>
        <div class="cur-metric-value" style="color:<?php echo e($chg>0?'var(--up)':($chg<0?'var(--down)':'var(--text-dim)')); ?>"><?php echo e($chg>0?'+':''); ?><?php echo e(number_format($chg,2)); ?>%</div>
      </div></div>
    </div>
    <?php endif; ?>
  </div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const td=<?php echo json_encode($trendData??[], 15, 512) ?>,rt=td.rates||[],lb=td.labels||[];
if(rt.length){
  const ctx=document.getElementById('trendChart').getContext('2d');
  const grad=ctx.createLinearGradient(0,0,0,240);
  grad.addColorStop(0,'rgba(240,184,75,.25)');
  grad.addColorStop(1,'rgba(240,184,75,0)');
  new Chart(ctx,{
    type:'line',
    data:{labels:lb,datasets:[{label:'<?php echo e($base); ?>/<?php echo e($target); ?>',data:rt,borderColor:'#F0B84B',backgroundColor:grad,tension:.4,fill:true,pointRadius:0,borderWidth:2}]},
    options:{
      responsive:true,
      interaction:{intersect:false,mode:'index'},
      plugins:{legend:{display:false},tooltip:{backgroundColor:'#16374C',titleColor:'#EAF2F6',bodyColor:'#EAF2F6',borderColor:'#20415A',borderWidth:1,padding:10,titleFont:{family:'IBM Plex Mono'},bodyFont:{family:'IBM Plex Mono'}}},
      scales:{
        y:{min:Math.min(...rt)*.995,max:Math.max(...rt)*1.005,ticks:{callback:v=>v.toFixed(2),color:'#7FA0B8',font:{family:'IBM Plex Mono',size:10}},grid:{color:'rgba(255,255,255,.05)'}},
        x:{ticks:{color:'#7FA0B8',font:{family:'IBM Plex Mono',size:10},maxTicksLimit:8},grid:{display:false}}
      }
    }
  });
} else {
  document.getElementById('trendChart').parentElement.innerHTML='<div class="cur-empty"><i class="bi bi-graph-up"></i>Data tren belum tersedia</div>';
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\Global Supply\supply-chain-platform\resources\views/currency/show.blade.php ENDPATH**/ ?>