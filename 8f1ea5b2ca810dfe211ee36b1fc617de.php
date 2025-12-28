

<?php $__env->startSection('title', 'Tous les Modules'); ?>

<?php $__env->startSection('content'); ?>
<div class="navbar">
    <div class="navbar-brand">Quiz App - <?php echo e(ucfirst(Auth::user()->role)); ?></div>
    <div class="navbar-menu">
        <?php if(Auth::user()->role === 'professor'): ?>
            <a href="<?php echo e(route('professor.dashboard')); ?>" class="navbar-link">← Retour au Dashboard</a>
        <?php elseif(Auth::user()->role === 'student'): ?>
            <a href="<?php echo e(route('student.dashboard')); ?>" class="navbar-link">← Retour au Dashboard</a>
        <?php else: ?>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="navbar-link">← Retour au Dashboard</a>
        <?php endif; ?>
        <span style="color: #6b7280;">👤 <?php echo e(Auth::user()->name); ?></span>
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-secondary">🚪 Déconnexion</button>
        </form>
    </div>
</div>

<div class="container">
    <h1>📚 Tous les Modules</h1>

    <div class="dashboard-stats" style="margin-top: 30px;">
        <div class="stat-card">
            <p>Total Modules</p>
            <h3><?php echo e($modules->count()); ?></h3>
        </div>
    </div>

    <div style="margin-top: 30px; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php if(Auth::user()->role === 'professor'): ?> <?php echo e(route('professor.module.quizzes', $module->module)); ?> 
                  <?php elseif(Auth::user()->role === 'student'): ?> <?php echo e(route('student.module.quizzes', $module->module)); ?>

                  <?php else: ?> <?php echo e(route('admin.module.quizzes', $module->module)); ?> <?php endif; ?>" 
           style="text-decoration: none;">
            <div class="card" style="cursor: pointer; transition: all 0.3s; border-left: 4px solid #667eea; height: 100%;">
                <h3 style="color: #667eea; margin-bottom: 15px; font-size: 24px;">
                    📚 <?php echo e($module->module); ?>

                </h3>
                <p style="color: #6b7280; margin-bottom: 8px; font-size: 16px;">
                    <strong>Quiz:</strong> <?php echo e($module->quiz_count); ?>

                </p>
                <p style="color: #6b7280; font-size: 16px;">
                    <strong>Groupes:</strong> <?php echo e($module->groupe_count); ?>

                </p>
                <p style="margin-top: 15px; color: #667eea; font-size: 14px; font-weight: 600;">
                    Cliquer pour voir les quiz →
                </p>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<style>
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aouif\Desktop\finallaravel\backend\resources\views/dashboard/modules.blade.php ENDPATH**/ ?>