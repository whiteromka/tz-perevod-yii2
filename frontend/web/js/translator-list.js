const { createApp } = Vue;

createApp({
    data() {
        return {
            translators: [],

            // Фильтры
            filters: {
                name: '',
                last_name: '',
                status: '',
                email: '',
                price_from: null,
                price_to: null,
                works_mode: '',
            },

            // Данные для фильтров (справочники)
            filtersData: {
                statusList: {},
                worksModeList: {},
            },

            // Пагинация
            pagination: {
                total: 0,        // Нашлось записей
                page: 1,         // Текущая страница
                'per-page': 10,  // Записей на одной странице
                'page-count': 0, // Общее количество страниц
            },

            loading: false,
            apiUrl: '/api/translator/list',
        };
    },

    computed: {
        // Вернет массивом номера страниц которые нужно отобразить в пагинации
        visiblePages() {
            const maxVisiblePages = 5;
            const currentPage = this.pagination.page;
            const totalPages = this.pagination['page-count'];

            // Если страниц меньше или равно максимальному количеству, показываем все
            if (totalPages <= maxVisiblePages) {
                return this.range(1, totalPages);
            }
            // Вычисляем начальную страницу
            let startPage = Math.max(1, currentPage - (Math.floor(maxVisiblePages / 2)));
            // Вычисляем конечную страницу
            let endPage = startPage + maxVisiblePages - 1;

            // Корректируем если вышли за пределы
            if (endPage > totalPages) {
                endPage = totalPages;
                startPage = endPage - maxVisiblePages + 1;
            }

            return this.range(startPage, endPage);
        },
    },

    methods: {
        // Для пагинации
        range(start, end) {
            const result = [];
            for (let i = start; i <= end; i++) {
                result.push(i);
            }
            return result;
        },

        // Запрос на бек
        async loadData() {
            this.loading = true;

            try {
                // Формируем параметры запроса и фильты
                const params = new URLSearchParams();
                params.set('page', this.pagination.page);
                params.set('per-page', this.pagination['per-page']);
                const f = this.filters;
                if (f.name) params.set('name', f.name);
                if (f.last_name) params.set('last_name', f.last_name);
                if (f.status) params.set('status', f.status);
                if (f.email) params.set('email', f.email);
                if (f.price_from) params.set('price_from', f.price_from);
                if (f.price_to) params.set('price_to', f.price_to);
                if (f.works_mode) params.set('works_mode', f.works_mode);

                const response = await fetch(`${this.apiUrl}?${params.toString()}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                //console.log(data)

                this.translators = data.items;
                this.pagination = data.pagination;
                this.filtersData = data.filters;

            } catch (error) {
                alert('Ошибка загрузки данных:', error);
            } finally {
                this.loading = false;
            }
        },


        //  Применение фильтра
        applyFilter() {
            this.pagination.page = 1;
            this.loadData();
        },

        // Смена страницы
        changePage(page) {
            if (page < 1 || page > this.pagination['page-count']) {
                return;
            }
            this.pagination.page = page;
            this.loadData();
        },

        // Получить текстовое значение статус
        getStatusText(status) {
            return this.filtersData.statusList[status] || status;
        },

        // Получить текстовое значение режима работы
        getWorksModeText(mode) {
            return this.filtersData.worksModeList[mode] || mode;
        },
    },

    mounted() {
        this.loadData();
    },
}).mount('#translator-app');
