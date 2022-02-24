<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:variable name="apos">'</xsl:variable>  
    <xsl:template match="//scheda">
       <table class="table table-border">
           <tr class="table-border">
                <td colspan="2" id="viewerImg">
                    <a title="Visualizza Oggetti digitali" id="viewImg">
                        <xsl:attribute name="onclick">showImg('<xsl:copy-of select="id/child::text()" />');</xsl:attribute>
                        <img alt="Visualizza Oggetti Digitali" class="objDigit" src="./plugins/content/tecadigitale/images/xlimage/images/object.gif"/>
                        <b>Visualizza Oggetti Digitali</b>
                    </a>
                    <a title="Visualizza Oggetti digitali" id="viewImgBlank"  target="_blank">
                        <xsl:attribute name="onclick">showImgPopup('<xsl:copy-of select="id/child::text()" />');</xsl:attribute>
                        <img alt="Visualizza Oggetti Digitali Finestra Separata" class="objDigitBlank" src="./plugins/content/tecadigitale/images/xlimage/images/object_blank.gif"/>
                        <b>Visualizza Oggetti Digitali Finestra Separata</b>
                    </a>
                </td>
            </tr>
            <xsl:apply-templates select="CD"/>
            <xsl:apply-templates select="OG"/>
            <xsl:apply-templates select="SG"/>
            <xsl:apply-templates select="LC"/>
            <xsl:apply-templates select="UB"/>
            <xsl:apply-templates select="DT"/>
            <xsl:apply-templates select="AU"/>
            <xsl:apply-templates select="MT"/>
            <xsl:apply-templates select="CO"/>
            <xsl:apply-templates select="TU"/>
            <xsl:apply-templates select="DO"/>
            <xsl:apply-templates select="AD"/>
            <xsl:apply-templates select="CM"/>
            <xsl:apply-templates select="MC"/>
            <xsl:apply-templates select="MM"/>
           <tr class="table-border">
                <td colspan="2" id="viewerImg">
                    <a title="Visualizza Oggetti digitali" id="viewImg">
                        <xsl:attribute name="onclick">showImg('<xsl:copy-of select="id/child::text()" />');</xsl:attribute>
                        <img alt="Visualizza Oggetti Digitali" class="objDigit" src="./plugins/content/tecadigitale/images/xlimage/images/object.gif"/>
                        <b>Visualizza Oggetti Digitali</b>
                    </a>
                    <a title="Visualizza Oggetti digitali" id="viewImgBlank"  target="_blank">
                        <xsl:attribute name="onclick">showImgPopup('<xsl:copy-of select="id/child::text()" />');</xsl:attribute>
                        <img alt="Visualizza Oggetti Digitali Finestra Separata" class="objDigitBlank" src="./plugins/content/tecadigitale/images/xlimage/images/object_blank.gif"/>
                        <b>Visualizza Oggetti Digitali Finestra Separata</b>
                    </a>
                </td>
            </tr>
        </table>
    </xsl:template>
    
    <xsl:template match="MM">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                METADATI DATO MULTIMEDIALE
            </td>
        </tr>
        <xsl:if test="MMT">
            <xsl:for-each select="MMT">
               <tr class="table-border">
                    <td id="subTitolo" colspan="2">
                        METADATI TECNICI DATO MULTIMEDIALE
                    </td>
                </tr>
                <xsl:if test="MMTO">
                   <tr class="table-border">
                        <td id="subTesto">
                            Nome file originale
                        </td>
                        <td id="value">
                            <xsl:for-each select="MMTO">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
               <tr class="table-border">
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="MC">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                METADATI DI CATALOGAZIONE
            </td>
        </tr>
        <xsl:if test="FTA">
            <xsl:for-each select="FTA">
               <tr class="table-border">
                    <td id="subTitolo" colspan="2">
                        DOCUMENTAZIONE FOTOGRAFICA
                    </td>
                </tr>
                <xsl:if test="FTAP">
                   <tr class="table-border">
                        <td id="subTesto">
                            Tipo
                        </td>
                        <td id="value">
                            <xsl:for-each select="FTAP">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="FTAN">
                   <tr class="table-border">
                        <td id="subTesto">
                            Codice identificativo
                        </td>
                        <td id="value">
                            <xsl:for-each select="FTAN">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
               <tr class="table-border">
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="CM">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                COMPILAZIONE
            </td>
        </tr>
        <xsl:if test="CMP">
            <xsl:for-each select="CMP">
               <tr class="table-border">
                    <td id="subTitolo" colspan="2">
                        COMPILAZIONE
                    </td>
                </tr>
                <xsl:if test="CMPD">
                   <tr class="table-border">
                        <td id="subTesto">
                            Data
                        </td>
                        <td id="value">
                            <xsl:for-each select="CMPD">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                <a>
                                    <xsl:attribute name="onclick">findTeca('dataCompilazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                    <xsl:copy-of select="child::text()"/>
                                </a>
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="CMPN">
                   <tr class="table-border">
                        <td id="subTesto">
                            Nome
                        </td>
                        <td id="value">
                            <xsl:for-each select="CMPN">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                <a>
                                    <xsl:attribute name="onclick">findTeca('compilatore','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                    <xsl:copy-of select="child::text()"/>
                                </a>
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
               <tr class="table-border">
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
        <xsl:if test="RSR">
           <tr class="table-border">
                <td id="testo">
                    Referente scientifico
                </td>
                <td id="value">
                    <xsl:for-each select="RSR">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        <a>
                            <xsl:attribute name="onclick">findTeca('referenteScientifico','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            <xsl:copy-of select="child::text()"/>
                        </a>
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="FUR">
           <tr class="table-border">
                <td id="testo">
                    Funzionario responsabile
                </td>
                <td id="value">
                    <xsl:for-each select="FUR">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        <a>
                            <xsl:attribute name="onclick">findTeca('funzionarioResponsabile','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            <xsl:copy-of select="child::text()"/>
                        </a>
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="AD">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                ACCESSO AI DATI
            </td>
        </tr>
        <xsl:if test="ADS">
            <xsl:for-each select="ADS">
               <tr class="table-border">
                    <td id="subTitolo" colspan="2">
                        SPECIFICHE DI ACCESSO AI DATI
                    </td>
                </tr>
                <xsl:if test="ADSP">
                   <tr class="table-border">
                        <td id="subTesto">
                            Profilo di accesso
                        </td>
                        <td id="value">
                            <xsl:for-each select="ADSP">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="ADSM">
                   <tr class="table-border">
                        <td id="subTesto">
                            Motivazione
                        </td>
                        <td id="value">
                            <xsl:for-each select="ADSM">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
               <tr class="table-border">
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="DO">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                FONTI E DOCUMENTI DI RIFERIMENTO
            </td>
        </tr>
        <xsl:if test="FTA">
            <xsl:for-each select="FTA">
               <tr class="table-border">
                    <td id="subTitolo" colspan="2">
                        DOCUMENTAZIONE FOTOGRAFICA
                    </td>
                </tr>
                <xsl:if test="FTAX">
                   <tr class="table-border">
                        <td id="subTesto">
                            Genere
                        </td>
                        <td id="value">
                            <xsl:for-each select="FTAX">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="FTAP">
                   <tr class="table-border">
                        <td id="subTesto">
                            Tipo
                        </td>
                        <td id="value">
                            <xsl:for-each select="FTAP">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="FTAN">
                   <tr class="table-border">
                        <td id="subTesto">
                            Codice identificativo
                        </td>
                        <td id="value">
                            <xsl:for-each select="FTAN">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
               <tr class="table-border">
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="TU">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                CONDIZIONE GIURIDICA E VINCOLI
            </td>
        </tr>
        <xsl:if test="CDG">
            <xsl:for-each select="CDG">
               <tr class="table-border">
                    <td id="subTitolo" colspan="2">
                        CONDIZIONE GIURIDICA
                    </td>
                </tr>
                <xsl:if test="CDGG">
                   <tr class="table-border">
                        <td id="subTesto">
                            Indicazione generica
                        </td>
                        <td id="value">
                            <xsl:for-each select="CDGG">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="CDGS">
                   <tr class="table-border">
                        <td id="subTesto">
                            Indicazione specifica
                        </td>
                        <td id="value">
                            <xsl:for-each select="CDGS">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
               <tr class="table-border">
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>

    <xsl:template match="CO">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                CONSERVAZIONE
            </td>
        </tr>
        <xsl:if test="STC">
            <xsl:for-each select="STC">
               <tr class="table-border">
                    <td id="subTitolo" colspan="2">
                        STATO DI CONSERVAZIONE
                    </td>
                </tr>
                <xsl:if test="STCC">
                   <tr class="table-border">
                        <td id="subTesto">
                            Stato di conservazione
                        </td>
                        <td id="value">
                            <xsl:for-each select="STCC">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="STCS">
                   <tr class="table-border">
                        <td id="subTesto">
                            Indicazioni specifiche
                        </td>
                        <td id="value">
                            <xsl:for-each select="STCS">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
               <tr class="table-border">
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="MT">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                DATI TECNICI
            </td>
        </tr>
        <xsl:if test="MTX">
           <tr class="table-border">
                <td id="testo">
                    Indicazione di colore
                </td>
                <td id="value">
                    <xsl:for-each select="MTX">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="MTC">
           <tr class="table-border">
                <td id="testo">
                    Materia e tecnica
                </td>
                <td id="value">
                    <xsl:for-each select="MTC">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="MIS">
            <xsl:for-each select="MIS">
               <tr class="table-border">
                    <td id="subTitolo" colspan="2">
                        MISURE
                    </td>
                </tr>
                <xsl:if test="MISO">
                   <tr class="table-border">
                        <td id="subTesto">
                            Tipo misure
                        </td>
                        <td id="value">
                            <xsl:for-each select="MISO">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="MISU">
                   <tr class="table-border">
                        <td id="subTesto">
                            <xsl:text disable-output-escaping="yes">Unit&amp;agrave; di misura</xsl:text>
                        </td>
                        <td id="value">
                            <xsl:for-each select="MISU">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="MISA">
                   <tr class="table-border">
                        <td id="subTesto">
                            Altezza
                        </td>
                        <td id="value">
                            <xsl:for-each select="MISA">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="MISL">
                   <tr class="table-border">
                        <td id="subTesto">
                            Larghezza
                        </td>
                        <td id="value">
                            <xsl:for-each select="MISL">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
               <tr class="table-border">
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="AU">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                
               DEFINIZIONE CULTURALE
            </td>
        </tr>
        <xsl:if test="AUF">
            <xsl:for-each select="AUF">
               <tr class="table-border">
                    <td id="subTitolo" colspan="2">
                        AUTORE DELLA FOTOGRAFIA
                    </td>
                </tr>
                <xsl:if test="AUFN">
                   <tr class="table-border">
                        <td id="subTesto">
                            Nome scelto (persona singola)
                        </td>
                        <td id="value">
                            <xsl:for-each select="AUFN">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                <a>
                                    <xsl:attribute name="onclick">findTeca('autore','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                    <xsl:copy-of select="child::text()"/>
                                </a>
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="AUFA">
                   <tr class="table-border">
                        <td id="subTesto">
                            Dati anagrafici/estremi cronologici
                        </td>
                        <td id="value">
                            <xsl:for-each select="AUFA">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="AUFR">
                   <tr class="table-border">
                        <td id="subTesto">
                            Riferimento all'intervento
                        </td>
                        <td id="value">
                            <xsl:for-each select="AUFR">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="AUFM">
                   <tr class="table-border">
                        <td id="subTesto">
                            Motivazione dell'attribuzione
                        </td>
                        <td id="value">
                            <xsl:for-each select="AUFM">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
               <tr class="table-border">
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="DT">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                CRONOLOGIA
            </td>
        </tr>
        <xsl:if test="DTZ">
           <tr class="table-border">
                <td id="subTitolo" colspan="2">
                    CRONOLOGIA GENERICA
                </td>
            </tr>
            <xsl:if test="DTZ/DTZG">
               <tr class="table-border">
                    <td id="subTesto">
                        Secolo
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTZ/DTZG">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('secoloIniziale','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
           <tr class="table-border">
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="DTS">
           <tr class="table-border">
                <td id="subTitolo" colspan="2">
                    CRONOLOGIA SPECIFICA
                </td>
            </tr>
            <xsl:if test="DTS/DTSI">
               <tr class="table-border">
                    <td id="subTesto">
                        Da
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTS/DTSI">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('data','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="DTS/DTSV">
               <tr class="table-border">
                    <td id="subTesto">
                        <xsl:text disable-output-escaping="yes">Validit&amp;agrave;</xsl:text>
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTS/DTSV">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="DTS/DTSF">
               <tr class="table-border">
                    <td id="subTesto">
                        A
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTS/DTSF">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('data','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="DTS/DTSL">
               <tr class="table-border">
                    <td id="subTesto">
                        <xsl:text disable-output-escaping="yes">Validit&amp;agrave;</xsl:text>
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTS/DTSL">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
           <tr class="table-border">
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="DTM">
           <tr class="table-border">
                <td id="subTitolo" colspan="2">
                    MOTIVAZIONE CRONOLOGIA
                </td>
            </tr>
            <xsl:if test="DTM/DTMM">
               <tr class="table-border">
                    <td id="subTesto">
                        Motivazione
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTM/DTMM">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
           <tr class="table-border">
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="UB">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                UBICAZIONE E DATI PATRIMONIALI
            </td>
        </tr>
        <xsl:if test="UBF">
           <tr class="table-border">
                <td id="subTitolo" colspan="2">
                    UBICAZIONE FOTO
                </td>
            </tr>
            <xsl:if test="UBF/UBFP">
               <tr class="table-border">
                    <td id="subTesto">
                        Fondo
                    </td>
                    <td id="value">
                        <xsl:for-each select="UBF/UBFP">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('fondo','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="UBF/UBFQ">
               <tr class="table-border">
                    <td id="subTesto">
                        Specifiche
                    </td>
                    <td id="value">
                        <xsl:for-each select="UBF/UBFQ">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('fondoSpecifiche','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="UBF/UBFC">
               <tr class="table-border">
                    <td id="subTesto">
                        Collocazione
                    </td>
                    <td id="value">
                        <xsl:for-each select="UBF/UBFC">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
           <tr class="table-border">
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
    </xsl:template>

    <xsl:template match="LC">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                LOCALIZZAZIONE GEOGRAFICO-AMMINISTRATIVA
            </td>
        </tr>
        <xsl:if test="PVC">
           <tr class="table-border">
                <td id="subTitolo" colspan="2">
                    LOCALIZZAZIONE GEOGRAFICO-AMMINISTRATIVA ATTUALE
                </td>
            </tr>
            <xsl:if test="PVC/PVCS">
               <tr class="table-border">
                    <td id="subTesto">
                        Stato
                    </td>
                    <td id="value">
                        <xsl:for-each select="PVC/PVCS">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('stato','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="PVC/PVCR">
               <tr class="table-border">
                    <td id="subTesto">
                        Regione
                    </td>
                    <td id="value">
                        <xsl:for-each select="PVC/PVCR">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('regione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="PVC/PVCP">
               <tr class="table-border">
                    <td id="subTesto">
                        Provincia
                    </td>
                    <td id="value">
                        <xsl:for-each select="PVC/PVCP">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('provincia','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="PVC/PVCC">
               <tr class="table-border">
                    <td id="subTesto">
                        Comune
                    </td>
                    <td id="value">
                        <xsl:for-each select="PVC/PVCC">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('comune','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
           <tr class="table-border">
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="LDC">
           <tr class="table-border">
                <td id="subTitolo" colspan="2">
                    COLLOCAZIONE SPECIFICA
                </td>
            </tr>
            <xsl:if test="LDC/LDCN">
               <tr class="table-border">
                    <td id="subTesto">
                        Denominazione
                    </td>
                    <td id="value">
                        <xsl:for-each select="LDC/LDCN">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:if test="child::text()='non identificabile'">
                                    <xsl:attribute name="onclick">findTeca('denominazione','Archivio Adda');</xsl:attribute>
                                    Archivio Adda
                                </xsl:if>
                                <xsl:if test="not(child::text()='non identificabile')">
                                    <xsl:attribute name="onclick">findTeca('denominazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                    <xsl:copy-of select="child::text()"/>
                                </xsl:if>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="LDC/LDCU">
               <tr class="table-border">
                    <td id="subTesto">
                        Denominazione spazio viabilistico
                    </td>
                    <td id="value">
                        <xsl:for-each select="LDC/LDCU">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('denominazioneIndirizzo','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="LDC/LDCM">
               <tr class="table-border">
                    <td id="subTesto">
                        Denominazione raccolta
                    </td>
                    <td id="value">
                        <xsl:for-each select="LDC/LDCM">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('denominazioneRaccolta','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
           <tr class="table-border">
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="SG">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                SOGGETTO
            </td>
        </tr>
        <xsl:if test="SGT">
           <tr class="table-border">
                <td id="subTitolo" colspan="2">
                    SOGGETTO
                </td>
            </tr>
            <xsl:if test="SGT/SGTI">
               <tr class="table-border">
                    <td id="subTesto">
                        Identificazione
                    </td>
                    <td id="value">
                        <xsl:for-each select="SGT/SGTI">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('soggetto','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="SGT/SGTD">
               <tr class="table-border">
                    <td id="subTesto">
                        Indicazioni sul soggetto
                    </td>
                    <td id="value">
                        <xsl:for-each select="SGT/SGTD">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
           <tr class="table-border">
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="SGL">
            <xsl:for-each select="SGL">
               <tr class="table-border">
                    <td id="subTitolo" colspan="2">
                        TITOLO
                    </td>
                </tr>
                <xsl:if test="SGLT">
                   <tr class="table-border">
                        <td id="subTesto">
                            Titolo proprio
                        </td>
                        <td id="value">
                            <xsl:for-each select="SGLT">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                <a>
                                    <xsl:attribute name="onclick">findTeca('titolo','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                    <xsl:copy-of select="child::text()"/>
                                </a>
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="SGLS">
                   <tr class="table-border">
                        <td id="subTesto">
                            Specifiche del titolo
                        </td>
                        <td id="value">
                            <xsl:for-each select="SGLS">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
               <tr class="table-border">
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="OG">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                OGGETTO
            </td>
        </tr>
        <xsl:if test="OGT">
           <tr class="table-border">
                <td id="subTitolo" colspan="2">
                    OGGETTO
                </td>
            </tr>
            <xsl:if test="OGT/OGTD">
               <tr class="table-border">
                    <td id="subTesto">
                        Definizione dell'oggetto
                    </td>
                    <td id="value">
                        <xsl:for-each select="OGT/OGTD">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="OGT/OGTB">
               <tr class="table-border">
                    <td id="subTesto">
                        Natura biblioteconomica dell'oggetto
                    </td>
                    <td id="value">
                        <xsl:for-each select="OGT/OGTB">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
           <tr class="table-border">
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="QNT">
           <tr class="table-border">
                <td id="subTitolo" colspan="2">
                    <xsl:text disable-output-escaping="yes">QUANTIT&amp;Agrave;</xsl:text>
                </td>
            </tr>
            <xsl:if test="QNT/QNTN">
               <tr class="table-border">
                    <td id="subTesto">
                        Numero oggetti/elementi
                    </td>
                    <td id="value">
                        <xsl:for-each select="QNT/QNTN">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
           <tr class="table-border">
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
    </xsl:template>

    <xsl:template match="CD">
       <tr class="table-border">
            <td id="titolo" colspan="2">
                CODICI
            </td>
        </tr>
        <xsl:if test="TSK">
           <tr class="table-border">
                <td id="testo">
                    Tipo Scheda
                </td>
                <td id="value">
                    <xsl:for-each select="TSK">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="LIR">
           <tr class="table-border">
                <td id="testo">
                    Livello ricerca
                </td>
                <td id="value">
                    <xsl:for-each select="LIR">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="NCT">
           <tr class="table-border">
                <td id="subTitolo" colspan="2">
                    CODICE UNIVOCO
                </td>
            </tr>
            <xsl:if test="NCT/NCTR">
               <tr class="table-border">
                    <td id="subTesto">
                        Codice regione
                    </td>
                    <td id="value">
                        <xsl:for-each select="NCT/NCTR">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="NCT/NCTN">
               <tr class="table-border">
                    <td id="subTesto">
                        Numero catalogo generale
                    </td>
                    <td id="value">
                        <xsl:for-each select="NCT/NCTN">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
           <tr class="table-border">
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="ESC">
           <tr class="table-border">
                <td id="testo">
                    Ente schedatore
                </td>
                <td id="value">
                    <xsl:for-each select="ESC">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        <a>
                            <xsl:attribute name="onclick">findTeca('enteSchedatore','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            <xsl:copy-of select="child::text()"/>
                        </a>
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="ECP">
           <tr class="table-border">
                <td id="testo">
                    Ente competente
                </td>
                <td id="value">
                    <xsl:for-each select="ECP">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        <a>
                            <xsl:attribute name="onclick">findTeca('enteCompetente','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            <xsl:copy-of select="child::text()"/>
                        </a>
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>