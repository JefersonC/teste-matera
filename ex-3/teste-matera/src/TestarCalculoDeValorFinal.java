import static org.hamcrest.CoreMatchers.is;
import static org.junit.jupiter.api.Assertions.*;

import org.junit.jupiter.api.Test;

class TestarCalculoDeValorFinal {
	/*
		Chamada ..................:	totalizaCarrinho(10, 0, 5)
		Resultado esperado .......:	15 - valor da compra somado ao frete
	*/
	@Test
	void testarSeRetornaValorAcrescidoDoFrete() {
		Carrinho carrinho = new Carrinho();
		
		assertEquals(carrinho.totalizaCarrinho(10, 0, 5), 15);
	}
	
	/*
		Chamada ..................:	totalizaCarrinho(0, 0.1, 10)
		Resultado esperado .......:	erro - o valor da compra não pode ser zero
	*/
	@Test
	void testarSeOValorDoProdutoFoiInformado() {
		Carrinho carrinho = new Carrinho();
		
		try {
			carrinho.totalizaCarrinho(0, .1, 10);
            fail("O sistema não deve permitir valor nulo para produtos"); //remember this line, else 'may' false positive
        } catch (RuntimeException e) {
            assertEquals(e.getMessage(), "O valor do produto é obrigatório");
        }
	}
	
	/*
		Chamada ..................:	totalizaCarrinho(10, .6, 5)
		Resultado esperado .......:	erro - desconto não pode ultrapassar 50%
	*/
	@Test
	void testarSeOSistemaImpedeDescontosMaioresQue50Porcento() {
		Carrinho carrinho = new Carrinho();
		
		try {
			carrinho.totalizaCarrinho(10, .6, 5);
            fail("O sistema não deve permitir descontos maiores que 50%"); //remember this line, else 'may' false positive
        } catch (RuntimeException e) {
            assertEquals(e.getMessage(), "O desconto não pode ser maior que 50%");
        }
	}
}
