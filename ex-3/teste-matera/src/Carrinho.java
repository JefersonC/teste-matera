
public class Carrinho {

	public double totalizaCarrinho(double valorDoProduto, double valorDoDesconto, double valorDoFrete) {
		
		if(valorDoProduto == 0) {
			throw new RuntimeException("O valor do produto é obrigatório");
		}
		
		if(valorDoDesconto > 0.5) {
			throw new RuntimeException("O desconto não pode ser maior que 50%");
		}
		
		if(valorDoProduto > 500) {
			valorDoFrete = 0;
		}
		
		double valorDoProdutoComDesconto = valorDoProduto;
		
		if(valorDoDesconto > 0) {
			valorDoProdutoComDesconto = valorDoProdutoComDesconto * (1 - valorDoDesconto);
		}
		
		return valorDoProdutoComDesconto + valorDoFrete;
	}
	
}
