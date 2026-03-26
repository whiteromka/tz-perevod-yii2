<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Переводчики';
?>

<div id="translator-app" class="container py-4">
    <h1 class="mb-4">Переводчики</h1>

    <!-- Фильтры -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="filter-name" class="form-label">Имя:</label>
                    <input type="text" class="form-control" id="filter-name" v-model="filters.name" @input="applyFilter" placeholder="Поиск по имени">
                </div>

                <div class="col-md-4">
                    <label for="filter-lastname" class="form-label">Фамилия:</label>
                    <input type="text" class="form-control" id="filter-lastname" v-model="filters.last_name" @input="applyFilter" placeholder="Поиск по фамилии">
                </div>

                <div class="col-md-4">
                    <label for="filter-email" class="form-label">Email:</label>
                    <input type="text" class="form-control" id="filter-email" v-model="filters.email" @input="applyFilter" placeholder="Поиск по email">
                </div>

                <div class="col-md-3">
                    <label for="filter-status" class="form-label">Статус:</label>
                    <select id="filter-status" class="form-select" v-model="filters.status" @change="applyFilter">
                        <option value="">Все</option>
                        <option v-for="(label, value) in filtersData.statusList" :key="value" :value="value">{{ label }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="filter-works-mode" class="form-label">Режим работы:</label>
                    <select id="filter-works-mode" class="form-select" v-model="filters.works_mode" @change="applyFilter">
                        <option value="">Все</option>
                        <option v-for="(label, value) in filtersData.worksModeList" :key="value" :value="value">{{ label }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="filter-price-from" class="form-label">Цена от:</label>
                    <input type="number" class="form-control" id="filter-price-from" v-model.number="filters.price_from" @change="applyFilter" placeholder="0">
                </div>

                <div class="col-md-3">
                    <label for="filter-price-to" class="form-label">Цена до:</label>
                    <input type="number" class="form-control" id="filter-price-to" v-model.number="filters.price_to" @change="applyFilter" placeholder="5000">
                </div>
            </div>
        </div>
    </div>

    <!-- Список переводчиков -->
    <div class="table-responsive" v-if="translators.length > 0">
        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Email</th>
                    <th>Статус</th>
                    <th>Цена/час</th>
                    <th>Режим работы</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="translator in translators" :key="translator.id">
                    <td>{{ translator.id }}</td>
                    <td>{{ translator.name }}</td>
                    <td>{{ translator.last_name }}</td>
                    <td>{{ translator.email }}</td>
                    <td>
                        <span :class="translator.status === 'active' ? 'badge bg-success' : 'badge bg-secondary'">
                            {{ getStatusText(translator.status) }}
                        </span>
                    </td>
                    <td>{{ translator.price }} ₽</td>
                    <td>{{ getWorksModeText(translator.works_mode) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Сообщение если нет данных -->
    <div class="alert alert-info text-center" v-else>
        <p class="mb-0">Переводчики не найдены</p>
    </div>

    <!-- Пагинация -->
    <nav v-if="pagination['page-count'] > 1" aria-label="Пагинация">
        <ul class="pagination justify-content-center">
            <li class="page-item" :class="{ disabled: pagination.page <= 1 }">
                <a class="page-link" href="#" @click.prevent="changePage(pagination.page - 1)">← Назад</a>
            </li>
            
            <li class="page-item" v-for="page in visiblePages" :key="page" :class="{ active: page === pagination.page }">
                <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
            </li>
            
            <li class="page-item" :class="{ disabled: pagination.page >= pagination.pageCount }">
                <a class="page-link" href="#" @click.prevent="changePage(pagination.page + 1)">Вперёд →</a>
            </li>
        </ul>
        <div class="text-center text-muted">
            <small>Страница {{ pagination.page }} из {{ pagination.pageCount }} (всего: {{ pagination.total }})</small>
        </div>
    </nav>

    <!-- Индикатор загрузки -->
    <div class="text-center py-4" v-if="loading">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Загрузка...</span>
        </div>
        <p class="mt-2">Загрузка...</p>
    </div>
</div>

<!-- Подключение Vue.js -->
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="<?= Url::to('@web/js/translator-list.js') ?>"></script>
