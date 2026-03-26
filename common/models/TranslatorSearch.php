<?php

namespace common\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Модель поиска для переводчиков
 */
class TranslatorSearch extends Translator
{
    /** @var int Размер страницы для пагинации */
    public $pageSize = 10;

    /** @var int Минимальная цена */
    public $price_from;

    /** @var int Максимальная цена */
    public $price_to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'price', 'price_from', 'price_to', 'pageSize'], 'integer'],
            [['name', 'last_name', 'status', 'email', 'works_mode', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * Поиск переводчиков по заданным параметрам
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Translator::find();
        $this->loadParams($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => isset($params['per-page']) ? (int)$params['per-page'] : $this->pageSize,
            ],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
        
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $this->filtering($query);

        return $dataProvider;
    }

    /**
     * Загрузит данные в поисковую модель
     *
     * @param array $params
     * @return void
     */
    private function loadParams(array $params): void
    {
        $formName = $this->formName();
        if (isset($params[$formName]) && is_array($params[$formName])) { // это для бекенда
            $this->load($params); // это для фронта
        } else {
            $this->load($params, '');
        }
    }

    /**
     * Применяет фильтры. Мутирует ActiveQuery $query
     *
     * @param ActiveQuery $query
     * @return void
     */
    private function filtering(ActiveQuery $query)
    {
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'last_name', $this->last_name]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['works_mode' => $this->works_mode]);

        if ($this->price_from !== null && $this->price_from !== '') {
            $query->andFilterWhere(['>=', 'price', $this->price_from]);
        }
        if ($this->price_to !== null && $this->price_to !== '') {
            $query->andFilterWhere(['<=', 'price', $this->price_to]);
        }
    }
}
