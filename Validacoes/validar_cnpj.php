<?php
function validar_cnpj($cnpj)
{
	// Valida tamanho
	if (strlen($cnpj) != 14)
		return false;
		// Valida primeiro d�gito verificador
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
		{
			$soma += $cnpj{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
			return false;
			// Valida segundo d�gito verificador
			for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
			{
				$soma += $cnpj{$i} * $j;
				$j = ($j == 2) ? 9 : $j - 1;
			}
			$resto = $soma % 11;
			return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
}
//var_dump(validar_cnpj('11.444.777/0001-61'));