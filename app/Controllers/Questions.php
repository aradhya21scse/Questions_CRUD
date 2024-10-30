<?php

namespace App\Controllers;

use App\Models\QuestionModel;
use App\Models\CategoryModel;

class Questions extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();       //new  instance of CategoryModel

        $data['categories'] = $categoryModel->FindCategories();    //get all categories from database

        $questionModel = new QuestionModel();                           //new  instance of QuestionModel

        $search = $this->request->getPost('search');                       //get search value from form

        $category_id = $this->request->getPost('category_id');             //get category id from form


        $questionperpage=5;                                                       //set number of questions per page

        $page=$this->request->getVar('page')?? 1;                          //get current page number from url or set to 1 if not set

        $totalquestions=$questionModel->getTotalQuestion($search,$category_id);   //get total number of questions from database

        $totalPages=ceil($totalquestions/$questionperpage);                          //calculate total number of pages

        $data['questions'] = $questionModel->getAllQuestions($questionperpage,$page,$search, $category_id);   //get all questions from database

        $data['page'] = $page;                                                         //set current page number in data array

        $data['totalPages'] = $totalPages;                                             
        $data['search'] = $search;
        $data['category_id'] = $category_id;
        $data['success'] = session()->getFlashdata('success');
        $data['error'] = session()->getFlashdata('error');

        return view('index', $data);
    }
    public function create()                      
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->FindCategories();
        return view('create', $data);  
    }

    public function store()      //function to  store/add new question in database

    {
        $model = new QuestionModel();

        $data = [
            'title' => $this->request->getPost('title'),                      
            'question' => $this->request->getPost('question'),
            'answer' => $this->request->getPost('answer'),
            'category_id' => $this->request->getPost('category_id')            
        ];

       
        if ($model->insertQuestion($data)) {
            session()->setFlashdata('success', 'Question added successfully.');     //insert data into database
        } else {
            session()->setFlashdata('error', 'Failed to add question.');
        }                

        return redirect()->to('/questions');
    }
    public function edit($id)                              //to open edit vew 

    {
        $model = new QuestionModel();
        $categoryModel = new CategoryModel();
        $data['question'] = $model->findById($id);                          //get question by id from database

        $data['categories'] = $categoryModel->FindCategories();                

        return view('edit', $data);                                 
    }

    public function update($id)             //function to update question in database
    {
        $model = new QuestionModel();

        $data = [
            'title' => $this->request->getPost('title'),
            'question' => $this->request->getPost('question'),
            'answer' => $this->request->getPost('answer'),
            'category_id' => $this->request->getPost('category_id')
        ];

        if($model->updateQuestion($id, $data)){
            session()->setFlashdata('success', 'Question updated successfully.');     //update data into database
        }else{
            session()->setFlashdata('error', 'Failed to update question.');
        }
        return redirect()->to('/questions');
    }

    public function delete($id)                           //function to delete question 

    {
        $model = new QuestionModel();
        if($model->deleteQuestion($id)){
            session()->setFlashdata('succes','Question Updated Successfully.')  ;            //delete from database
        }else{
            session()->setFlashdata('error','Failed to delete question.');
        }                           
        return redirect()->to('/questions');  
    }
    public function export()
{
    $questionModel = new QuestionModel();
    $questions = $questionModel->findAll(); 

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="questions.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Title', 'Question', 'Answer', 'Category ID']); // Adding the headers to the downloaded csv fle

    foreach ($questions as $question) {
        fputcsv($output, $question);
    }

    fclose($output);
    exit;
}

}
