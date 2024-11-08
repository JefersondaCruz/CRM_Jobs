<template>
    <div class="logo">
        <img src="../../public/img/jb.png">
    </div>
    <div id="jobs">
        <form id="FormRegister" class="row g-3">
            <div class="col-md-6">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" v-model="Title" placeholder="Digite o título da vaga">
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Descrição</label>
                <textarea class="form-control" v-model="Description" placeholder="Digite a descrição da vaga"></textarea>
            </div>
            
            <div class="col-12">
                <label for="salary" class="form-label">Salário</label>
                <input type="text" id="salary" class="form-control" v-model="Salary" placeholder="Digite o salário da vaga">
            </div>
            
            <div class="col-12">
                <label for="category" class="form-label">Categorias</label>
                <select id="category" class="form-select" v-model="Category">
                    <option selected disabled>Selecionar...</option>
                    <option>Desenvolvedor Back-end</option>
                    <option>Desenvolvedor Front-end</option>
                    <option>Marketing</option>
                    <option>Vendas</option>
                </select>
            </div>
            
            <button type="submit" class="btn">Cadastrar Vaga</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            Title: '',
            Description: '',
            Salary: '',
            Category: ''
        };
    },
    methods: {
        submitForm() {
            console.log({
                title: this.jobTitle,
                description: this.jobDescription,
                salary: this.jobSalary,
                category: this.jobCategory
            });
        }
    }
}
</script>

<style scoped>

    @import url('https://fonts.googleapis.com/css2?family=Creepster&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    * {
    font-family: "Poppins", serif;
    font-weight: 400;
    font-style: normal;
    }
    #jobs {
        background-color: #fff;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        max-width: 94%;
        padding: 20px;
        margin: 30px auto 0;
        border-radius: 8px;
    }

    textarea {
        height: 100px;
        resize: none;
    }

    .btn {
        border-radius: 20px;
        border: none;
        background-color: #E97A12;
        color: #ffffff;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
        cursor: pointer;
        transition: .5s ;
    }

    .btn:active {
        transform: scale(0.95);
    }
    .btn:hover {
        background-color: #ff8521;
    }

    .logo{
        display: flex;
        flex-direction: row;
        justify-content: center;
        margin-top: 10px;
    }
</style>
