function clickOnContinueButton() {
    cy.get('.btn').contains('Continuar').click();
    cy.wait(500);
}

describe('Página de Cadastro', () => {
    beforeEach(() => {
        cy.visit('/cadastro');

        Cypress.on('uncaught:exception', (err, runnable) => {
            // Verifica se o erro é referente ao Popper.js
            if (err.message.includes('i.createPopper is not a function')) {
                // Retorna false para prevenir que o teste falhe
                return false;
            }
        });
    });

    it('Clica no botão Voltar e verifica redirecionamento para a página inicial', () => {
        cy.contains('a', 'Voltar').click();

        cy.contains('Boas vindas, você chegou na Aurora!');
    });

    it('Verifica se a página de cadastro existe', () => {
        cy.title().should('include', 'Cadastro');

        cy.get('form.form-stepper').should('exist').and('be.visible');

        cy.get('#inputName').should('exist');
        cy.get('#inputBirdDate').should('exist');
        cy.get('#inputCPF').should('exist');
        cy.get('#inputPhone').should('exist');
        cy.get('#inputEmail').should('exist');
        cy.get('#inputPassword').should('exist');
        cy.get('#inputPasswordConfirm').should('exist');
    });

    it('Preenche os inputs e clica em Continuar', () => {
        cy.get('#inputName').type('João da Silva');
        cy.get('#inputBirdDate').type('1990-01-01');
        cy.get('#inputCPF').type('123.456.789-10');
        cy.get('#inputPhone').type('(11) 91234-5678');
        cy.get('#inputEmail').type('joao.silva@exemple.com');
        cy.get('#inputPassword').type('senha123');
        cy.get('#inputPasswordConfirm').type('senha123');

        clickOnContinueButton();
    });

    it('Verifica o título e subtítulo do formulário de aceite de políticas', () => {

        cy.get('h4').should('contain.text', 'Aceite de políticas');
        cy.get('p').should('contain.text', 'Para criar o seu perfil é necessário ler e aceitar os termos');
    });

    it('Executa clicks nos links e botões de aceite', () => {
        clickOnContinueButton();
        const politicas = [
            { link: 'Termos e condições de uso', modal: '#modalTerms' },
            { link: 'Política de privacidade', modal: '#modalPrivacy' },
            { link: 'Autorização de Uso de Imagem', modal: '#modalImage' }
        ];

        politicas.forEach((politica) => {
            cy.contains(politica.link).click();

            cy.wait(500);

            cy.get(politica.modal).contains('button', 'Aceitar').click();

        });
    });

    it('Verifica o título e subtítulo do perfil de agente cultural existe', () => {
        clickOnContinueButton();
        cy.get('.form-step-active > .btn-form-group > .btn-next').click();

        cy.get('h4').should('contain.text', 'Criação do Perfil');
        cy.get('p').should('contain.text', 'Para finalizar o seu cadastro, é necessário criar seu Perfil de Agente Cultural.');
    });

    it('Verifica os campos, preenche inputs, verifica o contador de caracteres e interage com as áreas de atuação', () => {
        clickOnContinueButton();
        cy.get('.form-step-active > .btn-form-group > .btn-next').click();

        const campos = ['#inputProfileName', '#inputProfileDescription', '#areas-container'];
        campos.forEach((campo) => {
            cy.get(campo).should('exist');
        });

        cy.get('#inputProfileName').type('João da Silva');

        const description = 'Sou um agente cultural com experiência em várias áreas da cultura.';
        cy.get('#inputProfileDescription').type(description);
        cy.get('#counter').should('contain.text', `${description.length}/400`);

        cy.get('#add-area-btn').click();

        cy.get('.dropdown-menu').contains('Área de interesse').click();

        cy.get('#areas-container').should('contain.text', 'Área de interesse');

        cy.get('.area-tag').contains('Área de interesse').within(() => {
            cy.get('.remove-tag').click();
        });
        cy.get('#areas-container').should('not.contain.text', 'Área de interesse');

        cy.contains('a', 'Criar conta').click();
    });
});
