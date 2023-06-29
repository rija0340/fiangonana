document.getElementById("btnPrint").addEventListener('click', function () {

    let tbl1 = document.getElementById("tatitraGeneralParMois")
    let tbl2 = document.getElementById("tatitraGeneralParMoisPourcentage")
    let tbl3 = document.getElementById("statKilasyRehetra")

    //stat par rubrique comparaison kilasy
    let tbl4 = document.getElementById("asafiParClasse")
    let tbl5 = document.getElementById("asaSoaParClasse")
    let tbl6 = document.getElementById("fampianaranaBaibolyParClasse")
    let tbl7 = document.getElementById("bokyNaTraktaParClasse")
    let tbl8 = document.getElementById("semineraKaoferansaParClasse")
    let tbl9 = document.getElementById("nahavitaFampianaranaParClasse")
    let tbl10 = document.getElementById("batisaParClasse")
    let tbl11 = document.getElementById("fanatitraParClasse")

    let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
    let worksheet_tmp2 = XLSX.utils.table_to_sheet(tbl2);
    let worksheet_tmp3 = XLSX.utils.table_to_sheet(tbl3);

    let worksheet_tmp4 = XLSX.utils.table_to_sheet(tbl4);
    let worksheet_tmp5 = XLSX.utils.table_to_sheet(tbl5);
    let worksheet_tmp6 = XLSX.utils.table_to_sheet(tbl6);
    let worksheet_tmp7 = XLSX.utils.table_to_sheet(tbl7);
    let worksheet_tmp8 = XLSX.utils.table_to_sheet(tbl8);
    let worksheet_tmp9 = XLSX.utils.table_to_sheet(tbl9);
    let worksheet_tmp10 = XLSX.utils.table_to_sheet(tbl10);
    let worksheet_tmp11 = XLSX.utils.table_to_sheet(tbl11);

    let a = XLSX.utils.sheet_to_json(worksheet_tmp1, {
        header: 1
    })

    let b = XLSX.utils.sheet_to_json(worksheet_tmp2, {
        header: 1
    })
    let c = XLSX.utils.sheet_to_json(worksheet_tmp3, {
        header: 1
    })

    let d = XLSX.utils.sheet_to_json(worksheet_tmp4, {
        header: 1
    })

    let e = XLSX.utils.sheet_to_json(worksheet_tmp5, {
        header: 1
    })
    let f = XLSX.utils.sheet_to_json(worksheet_tmp6, {
        header: 1
    })
    let g = XLSX.utils.sheet_to_json(worksheet_tmp7, {
        header: 1
    })
    let h = XLSX.utils.sheet_to_json(worksheet_tmp8, {
        header: 1
    })
    let i = XLSX.utils.sheet_to_json(worksheet_tmp9, {
        header: 1
    })
    let j = XLSX.utils.sheet_to_json(worksheet_tmp10, {
        header: 1
    })
    let k = XLSX.utils.sheet_to_json(worksheet_tmp11, {
        header: 1
    })


    // Ajouter les titres des tables aux données
    // let title2 = document.getElementById("titre2").innerText;

    a.unshift(["Tatitra général"]); // Insérer le titre 1 au début des données de la première table
    b.unshift(["Tatitra général impito"]); // Insérer le titre 2 au début des données de la deuxième table
    c.unshift(["Kilasy rehetra"]);
    d.unshift(["Asafi"]);
    e.unshift(["Asasoa"]);
    f.unshift(["Fampianarana baiboly"]);
    g.unshift(["Boky na trakta nozaraina"]);
    h.unshift(["Seminera na kaoferansa"]);
    i.unshift(["Nahavita fampianarana"]);
    j.unshift(["Batisa "]);
    k.unshift(["Fanatitra"]);

    let worksheet = XLSX.utils.json_to_sheet(
        a.concat(['']).concat(b)
            .concat(['']).concat(c)
            .concat(['']).concat(d)
            .concat(['']).concat(e)
            .concat(['']).concat(f)
            .concat(['']).concat(g)
            .concat(['']).concat(h)
            .concat(['']).concat(i)
            .concat(['']).concat(j)
            .concat(['']).concat(k)
        , { skipHeader: true });

    const new_workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(new_workbook, worksheet, "worksheet");
    XLSX.writeFile(new_workbook, 'tmp_file.xls');
});
