<?php

namespace App\Controllers;

use App\Models\QuestionModel;
use App\Models\CategoryModel;

class Questions extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->FindCategories(); 
        $questionModel = new QuestionModel();
        $search = $this->request->getPost('search');
        $category_id = $this->request->getPost('category_id');

        $questionperpage=5;
        $page=$this->request->getVar('page')?? 1;
        $totalquestions=$questionModel->getTotalQuestion($search,$category_id);
        $totalPages=ceil($totalquestions/$questionperpage);
        $data['questions'] = $questionModel->getAllQuestions($questionperpage,$page,$search, $category_id);
        $data['page'] = $page;
        $data['totalPages'] = $totalPages;
        $data['search'] = $search;
        $data['category_id'] = $category_id;

        return view('index', $data);
    }
    public function create()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->FindCategories();
        return view('create', $data);  
    }

    public function store()
    {
        $model = new QuestionModel();

        $data = [
            'title' => $this->request->getPost('title'),
            'question' => $this->request->getPost('question'),
            'answer' => $this->request->getPost('answer'),
            'category_id' => $this->request->getPost('category_id')
        ];

        $model->insertQuestion($data);
        return redirect()->to('/questions');
    }
    public function edit($id)
    {
        $model = new QuestionModel();
        $categoryModel = new CategoryModel();
        $data['question'] = $model->findById($id);  
        $data['categories'] = $categoryModel->FindCategories();  

        return view('edit', $data);  
    }

    public function update($id)
    {
        $model = new QuestionModel();

        $data = [
            'title' => $this->request->getPost('title'),
            'question' => $this->request->getPost('question'),
            'answer' => $this->request->getPost('answer'),
            'category_id' => $this->request->getPost('category_id')
        ];

        $model->updateQuestion($id, $data); 
        return redirect()->to('/questions');
    }

    public function delete($id)
    {
        $model = new QuestionModel();
        $model->deleteQuestion($id);  
        return redirect()->to('/questions');  
    }
}
