<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:include href="solrToScheda_SoggettoProduttore.xsl"/>
    <!--xsl:variable name="apos">'</xsl:variable-->
    <xsl:variable name="br"><br/></xsl:variable>
    <xsl:variable name="newLine">
</xsl:variable>
    <xsl:template match="/">
        <xsl:if test="//response/result/doc">
            <xsl:apply-templates select="//response/result/doc"/>
        </xsl:if>
        <xsl:if test="//scheda">
            <xsl:apply-templates select="//scheda"/>
        </xsl:if>
    </xsl:template>

    <xsl:template match="//response/result/doc">
        <h2 class="no-vertical-margin">Dettaglio scheda</h2>
        <h6><a class="btn-dettaglio-scheda no-vertical-margin" onclick="goBack()">Torna a risultati </a></h6>
        <script type="text/javascript">
            function goBack() {
              history.back();
            }
          </script>
        <table class="table table-border">
            <xsl:apply-templates select="arr[@name='bid_show']"/>
       	    <xsl:apply-templates select="arr[@name='soggettoConservatore_show']"/>
            <xsl:apply-templates select="arr[@name='soggettoProduttore_show']"/>
            <xsl:apply-templates select="arr[@name='fondo_show']"/>
            <xsl:apply-templates select="arr[@name='subFondo_show']"/>
            <xsl:apply-templates select="arr[@name='subFondo2_show']"/>
            <xsl:apply-templates select="arr[@name='collocazione_show']"/>
	</table>
        <table class="table table-border">
	    <xsl:if test="arr[@name='padre']">
            	<xsl:apply-templates select="arr[@name='padre']"/>
	    </xsl:if>
	    <xsl:if test="not(arr[@name='padre'])">
            	<xsl:apply-templates select="str[@name='_root_']"/>
	    </xsl:if>
	</table>
        <table class="table table-border">
            <!-- xsl:copy-of select="arr[@name='tipoOggetto_show']/str/child::text()"/><br/ -->
            <xsl:apply-templates select="arr[@name='originalFileName_show']"/>

            <xsl:choose>
                <xsl:when test="arr[@name='tipologiaFile_show']/str/child::text()='Uc'">
                    <xsl:apply-templates select="str[@name='_root_']"/>
                    <xsl:apply-templates select="arr[@name='tipologiaMateriale_show']"/>
                    <xsl:apply-templates select="arr[@name='titolo_show']"/>
                    <xsl:apply-templates select="arr[@name='lingua_show']"/>
                    <xsl:apply-templates select="arr[@name='dataCronica_show']"/>
                    <xsl:apply-templates select="arr[@name='dataTopica_show']"/>
                    <xsl:apply-templates select="arr[@name='supporto_show']"/>
                    <xsl:apply-templates select="arr[@name='tecnica_show']"/>
                    <xsl:apply-templates select="arr[@name='dimensione_show']"/>
                    <xsl:apply-templates select="arr[@name='scala_show']"/>
                    <xsl:apply-templates select="arr[@name='statoConservazione_show']"/>
                    <xsl:apply-templates select="arr[@name='autore_show']"/>
                    <xsl:apply-templates select="arr[@name='datiFruizione_show']"/>
                    <xsl:apply-templates select="arr[@name='dataCompilazione_show']"/>
                    <xsl:apply-templates select="arr[@name='note_show']"/>
                </xsl:when>
                <xsl:when test="arr[@name='tipologiaFile_show']/str/child::text()='Ud'">
                    <xsl:apply-templates select="arr[@name='tipologiaUnitaArchivistica_show']"/>
                    <xsl:apply-templates select="arr[@name='titolo_show']"/>
                    <xsl:apply-templates select="arr[@name='lingua_show']"/>
                    <xsl:apply-templates select="arr[@name='annoIniziale_show']"/>
                    <xsl:apply-templates select="arr[@name='annoFinale_show']"/>
                    <xsl:apply-templates select="arr[@name='secoloIniziale_show']"/>
                    <xsl:apply-templates select="arr[@name='secoloFinale_show']"/>
                    <xsl:apply-templates select="arr[@name='supporto_show']"/>
                    <xsl:apply-templates select="arr[@name='consistenzaCarte_show']"/>
                    <xsl:apply-templates select="arr[@name='statoConservazione_show']"/>
                    <xsl:apply-templates select="arr[@name='documentiCatografici_show']"/>
                    <xsl:apply-templates select="arr[@name='children_show']"/>
                    <xsl:apply-templates select="arr[@name='dataCompilazione_show']"/>
                    <xsl:apply-templates select="arr[@name='note_show']"/>
                </xsl:when>
                <xsl:when test="arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore'">
                    <xsl:apply-templates select="arr[@name='titolo_show']"/>
                    <xsl:apply-templates select="arr[@name='tipoSoggettoConservatore_show']"/>
                    <xsl:apply-templates select="arr[@name='descrizione_show']"/>
                    <xsl:apply-templates select="arr[@name='indirizzo_show']"/>
                    <xsl:apply-templates select="arr[@name='telefono_show']"/>
                    <xsl:apply-templates select="arr[@name='fax_show']"/>
                    <xsl:apply-templates select="arr[@name='email_show']"/>
                    <xsl:apply-templates select="arr[@name='servizioPub_show']"/>
                    <xsl:apply-templates select="arr[@name='orarioApertura_show']"/>
                    <xsl:apply-templates select="arr[@name='schedeConservatori_show']"/>
                    <xsl:apply-templates select="arr[@name='risorseEsterne_show']"/>
                    <xsl:apply-templates select="arr[@name='children_show']"/>
                </xsl:when>
                <xsl:when test="arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico'">
                    <xsl:apply-templates select="arr[@name='titolo_show']"/>
                    <xsl:apply-templates select="arr[@name='tipologia_show']"/>
                    <xsl:apply-templates select="arr[@name='estremi_show']"/>
                    <xsl:apply-templates select="arr[@name='consistenzaCarte_show']"/>
                    <xsl:apply-templates select="arr[@name='consistenzaSast_show']"/>
                    <xsl:apply-templates select="arr[@name='descrizione_show']"/>
                    <xsl:apply-templates select="arr[@name='schedaProvenienzaUrl_show']"/>
                    <xsl:apply-templates select="arr[@name='storiaArchivistica_show']"/>
                    <xsl:apply-templates select="arr[@name='children_show']"/>
                </xsl:when>
                <xsl:when test="arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore'">
                    <xsl:apply-templates select="arr[@name='tipologia_show']"/>
                    <xsl:apply-templates select="arr[@name='titolo_show']"/>
                    <xsl:apply-templates select="arr[@name='altreDenominazioni_show']"/>
                    <xsl:apply-templates select="arr[@name='dataEsistenza_show']"/>
                    <xsl:apply-templates select="arr[@name='dataMorte_show']"/>
                    <xsl:apply-templates select="arr[@name='luogoNascita_show']"/>
                    <xsl:apply-templates select="arr[@name='luogoMorte_show']"/>
                    <xsl:apply-templates select="arr[@name='sede_show']"/>
                    <xsl:apply-templates select="arr[@name='naturaGiuridica_show']"/>
                    <xsl:apply-templates select="arr[@name='tipoEnte_show']"/>
                    <xsl:apply-templates select="arr[@name='ambitoTerritoriale_show']"/>
                    <xsl:apply-templates select="arr[@name='titoloSP_show']"/>
                    <xsl:apply-templates select="arr[@name='descrizione_show']"/>
                    <xsl:apply-templates select="arr[@name='schedaProvenienzaUrl_show']"/>
                </xsl:when>
                <xsl:when test="arr[@name='tipoOggetto_show']/str/child::text()='agente' and
                                arr[@name='agentType_show']/str/child::text()='depositante'">
                    <xsl:apply-templates select="arr[@name='agentIdentifier_show']"/>
                    <xsl:apply-templates select="arr[@name='agentName_show']"/>
                    <xsl:apply-templates select="arr[@name='agentType_show']"/>
                    <xsl:apply-templates select="arr[@name='agentNote_show']"/>
                    <xsl:apply-templates select="arr[@name='url_show']"/>
                </xsl:when>
                <xsl:when test="arr[@name='tipoOggetto_show']/str/child::text()='diritti'">
                    <xsl:apply-templates select="arr[@name='rightsIdentifier_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsBasis_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsInformationBasis_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsAct_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsRestriction_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsObjectIdentifier_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsStatuteJurisdiction_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsStatuteCitation_show']"/>
                </xsl:when>
                <xsl:when test="arr[@name='tipoOggetto_show']/str/child::text()='evento' and
                                arr[@name='eventType_show']/str/child::text()='send'">
                    <xsl:apply-templates select="arr[@name='eventID_show']"/>
                    <xsl:apply-templates select="arr[@name='eventType_show']"/>
                    <xsl:apply-templates select="arr[@name='eventDate_show']"/>
                    <xsl:apply-templates select="arr[@name='eventOutCome_show']"/>
                    <xsl:apply-templates select="arr[@name='eventDetail_show']"/>
                    <xsl:apply-templates select="arr[@name='agentDepositante_show']"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates select="arr[@name='journalTitolo_show']"/>
                    <xsl:apply-templates select="arr[@name='titolo_show']"/>
                    <xsl:apply-templates select="arr[@name='lingua_show']"/>
                    <xsl:apply-templates select="arr[@name='autore_show']"/>
                    <xsl:apply-templates select="arr[@name='descrizione_show']"/>
                    <xsl:apply-templates select="arr[@name='provenienzaOggetto_show']"/>
                    <xsl:apply-templates select="arr[@name='tipoContenitore_show']"/>
                    <xsl:apply-templates select="arr[@name='objectIdentifier_show']"/>
                    <xsl:apply-templates select="arr[@name='fileType_show']"/>
                    <xsl:apply-templates select="arr[@name='actualFileName_show']"/>
                    <xsl:apply-templates select="arr[@name='compositionLevel_show ']"/>
                    <xsl:apply-templates select="arr[@name='sha1_show']"/>
                    <xsl:apply-templates select="arr[@name='size_show']"/>
                    <xsl:apply-templates select="arr[@name='mimeType_show']"/>
                    <xsl:apply-templates select="arr[@name='promon_show']"/>
                    <xsl:apply-templates select="arr[@name='rights_show']"/>
                    <xsl:apply-templates select="arr[@name='tarIndex_show']"/>
                    <xsl:apply-templates select="arr[@name='relationshipType_show']"/>
                    <xsl:apply-templates select="arr[@name='eventID_show']"/>
                    <xsl:apply-templates select="arr[@name='eventType_show']"/>
                    <xsl:apply-templates select="arr[@name='eventDate_show']"/>
                    <xsl:apply-templates select="arr[@name='eventOutCome_show']"/>
                    <xsl:apply-templates select="arr[@name='eventDetail_show']"/>
                    <xsl:apply-templates select="arr[@name='agentDepositante_show']"/>
                    <xsl:apply-templates select="arr[@name='agentSoftware_show']"/>
                    <xsl:apply-templates select="arr[@name='nodo_show']"/>
                    <xsl:apply-templates select="arr[@name='tipoDocumento_show']"/>
                    <xsl:apply-templates select="arr[@name='bni_show']"/>
                    <xsl:apply-templates select="arr[@name='pubblicazione_show']"/>
                    <xsl:apply-templates select="arr[@name='soggetto_show']"/>
                    <xsl:apply-templates select="arr[@name='contributo_show']"/>
                    <xsl:apply-templates select="arr[@name='data_show']"/>
                    <xsl:apply-templates select="arr[@name='tiporisorsa_show']"/>
                    <xsl:apply-templates select="arr[@name='formato_show']"/>
                    <xsl:apply-templates select="arr[@name='fonte_show']"/>
                    <xsl:apply-templates select="arr[@name='relazione_show']"/>
                    <xsl:apply-templates select="arr[@name='copertura_show']"/>
                    <xsl:apply-templates select="arr[@name='gestionediritti_show']"/>
                    <xsl:apply-templates select="arr[@name='biblioteca_show']"/>
                    <xsl:apply-templates select="arr[@name='inventario_show']"/>
                    <xsl:apply-templates select="arr[@name='piecegr_show']"/>
                    <xsl:apply-templates select="arr[@name='piecedt_show']"/>
                    <xsl:apply-templates select="arr[@name='piecein_show']"/>
                    <xsl:apply-templates select="arr[@name='indexed_show']"/>
                    <xsl:apply-templates select="arr[@name='pageStart_show']"/>
                    <xsl:apply-templates select="arr[@name='pageEnd_show']"/>
                    <xsl:apply-templates select="arr[@name='agentIdentifier_show']"/>
                    <xsl:apply-templates select="arr[@name='agentName_show']"/>
                    <xsl:apply-templates select="arr[@name='agentType_show']"/>
                    <xsl:apply-templates select="arr[@name='agentNote_show']"/>
                    <xsl:apply-templates select="arr[@name='agentIdIstituzione_show']"/>
                    <xsl:apply-templates select="arr[@name='agentIdRigths_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsIdentifier_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsBasis_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsInformationBasis_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsAct_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsRestriction_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsObjectIdentifier_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsStatuteJurisdiction_show']"/>
                    <xsl:apply-templates select="arr[@name='rightsStatuteCitation_show']"/>
                    <xsl:apply-templates select="arr[@name='nbn_show']"/>
                    <xsl:apply-templates select="arr[@name='url_show']"/>
                    <xsl:apply-templates select="arr[@name='agentMachine_show']"/>
                    <xsl:apply-templates select="arr[@name='registroId_show']"/>
                    <xsl:apply-templates select="arr[@name='registroTimeStampIngest_show']"/>
                    <xsl:apply-templates select="arr[@name='registroContainerFingerPrint_show']"/>
                    <xsl:apply-templates select="arr[@name='registroContainerFingerPrintChain_show']"/>
                    <xsl:apply-templates select="arr[@name='registroContainerType_show']"/>
                    <xsl:apply-templates select="arr[@name='registroStatus_show']"/>
                    <xsl:apply-templates select="arr[@name='registroTimeStampInit_show']"/>
                    <xsl:apply-templates select="arr[@name='registroTimeStampElab_show']"/>
                    <xsl:apply-templates select="arr[@name='registroTimeStampCoda_show']"/>
                    <xsl:apply-templates select="arr[@name='registroTimeStampPub_show']"/>
                    <xsl:apply-templates select="arr[@name='registroTimeStampErr_show']"/>
                </xsl:otherwise>
            </xsl:choose>
            <xsl:apply-templates select="arr[@name='originalFileName_show']"/>
        </table>
    </xsl:template>

    <xsl:template match="arr[@name='agentMachine_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Agent Machine
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='registroId_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                ID Registro
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='registroTimeStampIngest_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Data Ora Ingest
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='registroContainerFingerPrint_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Finger Print
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='registroContainerFingerPrintChain_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Finger Print Chain
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='registroContainerType_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Container Type
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='registroStatus_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Status
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='registroTimeStampInit_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Data Ora Inizio elaborazione
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='registroTimeStampElab_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Data Ora fine elaborazione
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='registroTimeStampCoda_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Data Ora generazione Coda GeoReplica
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='registroTimeStampPub_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Data Ora fine pubblicazione su Solr
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='registroTimeStampErr_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Data e Ora riscontro Errore
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='nbn_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Codice NBN
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='url_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                <xsl:if test="../arr[@name='tipoOggetto_show']/str/child::text()='agente' and
                                ../arr[@name='agentType_show']/str/child::text()='depositante'">
                  Agent URL
                </xsl:if>
                <xsl:if test="not(../arr[@name='tipoOggetto_show']/str/child::text()='agente' and
                                ../arr[@name='agentType_show']/str/child::text()='depositante')">
                  Link risorsa digitale
                </xsl:if>
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                      <a target="_blank">
                        <xsl:attribute name="href"><xsl:copy-of select="child::text()" /></xsl:attribute>
                          <xsl:copy-of select="child::text()" />
                      </a>
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='rightsIdentifier_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Codice Identificativo del Rights
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <a>
                            <xsl:attribute name="onclick">findTeca('rights','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <xsl:copy-of select="child::text()" />
			</a>
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='rightsBasis_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Rights Basis
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='rightsInformationBasis_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Rights Information Basis
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='rightsAct_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Rights Act
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='rightsRestriction_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Rights Restriction
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='rightsObjectIdentifier_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
               Identificativo diritti
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='rightsStatuteJurisdiction_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Rights Statute Jurisdiction
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='rightsStatuteCitation_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Rights Statute Citation
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='agentIdentifier_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Codice di identificazione Agente
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                      <xsl:if test="arr[@name='tipoOggetto_show']/str/child::text()='agente' and
                                arr[@name='agentType_show']/str/child::text()='depositante'">
                        <a>
                            <xsl:attribute name="onclick">findTeca('agentDepositante','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            <xsl:copy-of select="child::text()" />
			</a>
                      </xsl:if>
                      <xsl:if test="not(arr[@name='tipoOggetto_show']/str/child::text()='agente' and
                                arr[@name='agentType_show']/str/child::text()='depositante')">
                            <xsl:copy-of select="child::text()" />
                      </xsl:if>
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='agentName_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Agent Nome
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='agentType_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Agent Type
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='agentNote_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Agent Note
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='agentIdIstituzione_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Istituto
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='agentIdRigths_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Rights
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()" />
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='originalFileName_show']">
        <xsl:if test="../urlObj">
            <tr class="table-border">
                <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Link elemento archiviato
                </td>
                <td class="col-md-9 label-dettaglio-border">
                <a title="Visualizza Oggetti digitali Finestra Separata" id="viewImgBlank"  target="_blank">
                        <xsl:attribute name="href"><xsl:copy-of select="../urlObj/child::text()" /></xsl:attribute>
                    <xsl:copy-of select="../urlObj/child::text()" />
                        <!--<img alt="Visualizza Oggetti Digitali Finestra Separata" class="objDigitBlank" src="/wp-content/plugins/md-opac/images/xlimage/images/object_blank.gif"/>
                        b>Visualizza Oggetti Digitali Finestra Separata</b -->
                    </a>
                      <p class="numberView" id="numberView">Visualizzato
                        <xsl:choose>
                            <xsl:when test="not(../numberView)">0 Volte</xsl:when>
                            <xsl:when test="../numberView/child::text()=1">1 Volta</xsl:when>
                            <xsl:otherwise><xsl:copy-of select="../numberView/child::text()" /> Volte</xsl:otherwise>
                        </xsl:choose>
                    </p>
                </td>
               <!-- <td colspan="2">
                    accedi oggetto archiviato
                    <a title="Visualizza Oggetti digitali" id="viewImg">
                        <xsl:attribute name="href"><xsl:copy-of select="../urlObj/child::text()" /></xsl:attribute>
                       <img alt="Visualizza Oggetti Digitali" class="objDigit" src="/wp-content/plugins/md-opac/images/xlimage/images/object.gif"/>
                    </a>
                    <a title="Visualizza Oggetti digitali Finestra Separata" id="viewImgBlank"  target="_blank">
                        <xsl:attribute name="href"><xsl:copy-of select="../urlObj/child::text()" /></xsl:attribute>
                        <img alt="Visualizza Oggetti Digitali Finestra Separata" class="objDigitBlank" src="/wp-content/plugins/md-opac/images/xlimage/images/object_blank.gif"/>
                        b>Visualizza Oggetti Digitali Finestra Separata</b
                    </a>
                    <p class="numberView" id="numberView">Visualizzato
                        <xsl:choose>
                            <xsl:when test="not(../numberView)">0 Volte</xsl:when>
                            <xsl:when test="../numberView/child::text()=1">1 Volta</xsl:when>
                            <xsl:otherwise><xsl:copy-of select="../numberView/child::text()" /> Volte</xsl:otherwise>
                        </xsl:choose>
                    </p>
                </td> -->
            </tr>
        </xsl:if>
    </xsl:template>

    <xsl:template match="arr[@name='bid_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Identificativo
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <xsl:if test="../../arr[@name='tipologiaFile_show'][1]/str/child::text()='Uc' or ../../arr[@name='tipologiaFile_show'][1]/str/child::text()='Ud'">
                        <a>
                            <xsl:attribute name="onclick">findTeca('bid','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </a>
                    </xsl:if>
                    <xsl:if test="../../arr[@name='tipologiaFile_show'][1]/str/child::text()!='Uc' and ../../arr[@name='tipologiaFile_show'][1]/str/child::text()!='Ud'">
                        
                            <xsl:copy-of select="child::text()" />
                        
                    </xsl:if>
                    <xsl:if test="not(../../arr[@name='tipologiaFile_show'])">
                        
                            <xsl:copy-of select="child::text()" />
                        
                    </xsl:if>
                    <br/>
                </xsl:for-each>
                <xsl:if test="../arr[@name='bidUrl_show']">
                    
                        <xsl:copy-of select="../arr[@name='bidUrl_show']" />
                    
                </xsl:if>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='collocazione_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Collocazione/posizione all'interno dell'archivio
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='padre']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                <xsl:choose>
                    <xsl:when test="../arr[@name='tipoOggetto_show'][1]/str/child::text()='documento'">
                        oggetto file collegato
                    </xsl:when>
                    <xsl:when test="../arr[@name='tipoOggetto_show'][1]/str/child::text()='file'">
                        oggetto contenitore collegato
                    </xsl:when>
                    <xsl:when test="../arr[@name='tipologiaFile_show']/str/child::text()">
                        Documento non cartografico di riferimento
                    </xsl:when>
                    <xsl:otherwise>
                        Oggetto padre collegata
                    </xsl:otherwise>
                </xsl:choose>
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:choose>
                    <xsl:when test="../arr[@name='tipologiaFile_show']/str/child::text()">
                        <a title="bid">
                            <xsl:attribute name="onclick">showSchedaByBid('<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            
                                <xsl:copy-of select="../str[@name='_rootDesc_']/child::text()"/>
                            
                        </a>
                    </xsl:when>
                    <xsl:otherwise>
			<xsl:for-each select="str">
                        <a title="bid">

                            <xsl:attribute name="onclick">showScheda('<xsl:copy-of select="translate(.,$apos,'')" />');</xsl:attribute>
                            
                                <xsl:copy-of select="."/>
                            
                        </a><br/>
			</xsl:for-each>
                    </xsl:otherwise>
                </xsl:choose>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="str[@name='_root_']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                <xsl:choose>
                    <xsl:when test="../arr[@name='tipologiaFile_show']/str/child::text()">
                        Documento non cartografico di riferimento
                    </xsl:when>
                    <xsl:otherwise>
                        Oggetto padre collegata
                    </xsl:otherwise>
                </xsl:choose>
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:choose>
                    <xsl:when test="../arr[@name='tipologiaFile_show']/str/child::text()">
                        <a title="bid">
                            <xsl:attribute name="onclick">showSchedaByBid('<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            
                                <xsl:copy-of select="../str[@name='_rootDesc_']/child::text()"/>
                            
                        </a>
                    </xsl:when>
                    <xsl:otherwise>
                        <a title="bid">
                            <xsl:attribute name="onclick">showScheda('<xsl:copy-of select="translate(.,$apos,'')" />');</xsl:attribute>
                            
                                <xsl:copy-of select="."/>
                            
                        </a>
                    </xsl:otherwise>
                </xsl:choose>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='journalTitolo_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Journal titolo
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    
                        <xsl:copy-of select="child::text()"/>
                    
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='titolo_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                <xsl:if test="../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore'">
                    Istituto
                </xsl:if>
                <xsl:if test="../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico'">
                    Complesso Archivistico
                </xsl:if>
                <xsl:if test="not(../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore') and
                    not(../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico')">
                    Denominazione o titolo
                </xsl:if>
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <xsl:if test="not(../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore') and
                        not(../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico') and
                        not(../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore')">
                        <a>
                            <xsl:attribute name="onclick">findTeca('titolo','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </a>
                    </xsl:if>
                    <xsl:if test="../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore' or
                        ../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico' or
                        ../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore'">
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </xsl:if>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='lingua_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Lingua
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('lingua','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='autore_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Autore e qualifica
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('autore','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='descrizione_show']">
        <tr class="table-border">
          <td class="col-md-3 label-dettaglio label-dettaglio-border">
            Breve descrizione
          </td>
          <td class="col-md-9 label-dettaglio-border">
            <xsl:for-each select="str">
                <!-- a>
                    <xsl:attribute name="onclick">findTeca('bid','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                    
                <!-- /a --><br/>
            </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='pageStart_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Pagina Partenza
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!-- a>
                    <xsl:attribute name="onclick">findTeca('bid','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                    
                    <!-- /a --><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='pageEnd_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Pagina Arrivo
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!-- a>
                    <xsl:attribute name="onclick">findTeca('bid','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                    
                    <!-- /a --><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
</xsl:stylesheet>
