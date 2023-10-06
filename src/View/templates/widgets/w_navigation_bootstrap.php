<?php use App\Service\Helpers\LinkManager; ?>
<?php use Symfony\Component\HttpFoundation\Request; ?>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= Request::createFromGlobals()->getPathInfo() === LinkManager::link('/') ? "active" : ""; ?>" aria-current="page" href="<?= LinkManager::link('/') ?>">
                    <span data-feather="home"></span>
                    Home page
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains(Request::createFromGlobals()->getPathInfo(), '/show') ? "active" : ""; ?>" href="<?= LinkManager::link('/show', ['page' => 1]) ?>">
                    <span data-feather="layout"></span>
                    Show
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains(Request::createFromGlobals()->getPathInfo(), '/create') ? "active" : ""; ?>" href="<?= LinkManager::link('/create') ?>">
                    <span data-feather="save"></span>
                    Create
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= str_contains(Request::createFromGlobals()->getPathInfo(), '/update') ? "active" : ""; ?>" href="<?= LinkManager::link('/update') ?>">
                    <span data-feather="edit"></span>
                    Update
                </a>
            </li>
        </ul>

        <!--        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">-->
        <!--            <span>Saved reports</span>-->
        <!--            <a class="link-secondary" href="#" aria-label="Add a new report">-->
        <!--                <span data-feather="plus-circle"></span>-->
        <!--            </a>-->
        <!--        </h6>-->
        <!--        <ul class="nav flex-column mb-2">-->
        <!--            <li class="nav-item">-->
        <!--                <a class="nav-link" href="#">-->
        <!--                    <span data-feather="file-text"></span>-->
        <!--                    Current month-->
        <!--                </a>-->
        <!--            </li>-->
        <!--            <li class="nav-item">-->
        <!--                <a class="nav-link" href="#">-->
        <!--                    <span data-feather="file-text"></span>-->
        <!--                    Last quarter-->
        <!--                </a>-->
        <!--            </li>-->
        <!--            <li class="nav-item">-->
        <!--                <a class="nav-link" href="#">-->
        <!--                    <span data-feather="file-text"></span>-->
        <!--                    Social engagement-->
        <!--                </a>-->
        <!--            </li>-->
        <!--            <li class="nav-item">-->
        <!--                <a class="nav-link" href="#">-->
        <!--                    <span data-feather="file-text"></span>-->
        <!--                    Year-end sale-->
        <!--                </a>-->
        <!--            </li>-->
        <!--        </ul>-->


