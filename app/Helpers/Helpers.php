<?php

if (!function_exists('formatPhone')) {
    function formatPhone($phone) {
        // Remove tudo que não for dígito
        $phone = preg_replace('/\D/', '', $phone);
        if ($phone == '') {
            return $phone;
        }
        // Formatação do telefone (xx) xxxxx-xxxx
        $phone = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $phone);
        if ($phone == '') {
            return $phone;
        }
        return $phone;
    }
}
if (!function_exists('formatMoney')) {
    // format money pt-BR
    function formatMoney($number) {
        return number_format($number, 2, ',', '.');
    }
}
if (!function_exists('formatCPF')) {
    function formatCPF($cpf) {
        // Remove tudo que não for dígito
        $cpf = preg_replace('/\D/', '', $cpf);
        // Formatação do CPF xxx.xxx.xxx-xx
        $cpf = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
        return $cpf;
    }
}

if (!function_exists('formatCPFHidden')) {
    function formatCPFHidden($cpf) {
        // Remove tudo que não for dígito
        $cpf = preg_replace('/\D/', '', $cpf);
        // Formatação do CPF xxx.xxx.xxx-xx
        $cpf = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.***.***-$4', $cpf);
        return $cpf;
    }
}
