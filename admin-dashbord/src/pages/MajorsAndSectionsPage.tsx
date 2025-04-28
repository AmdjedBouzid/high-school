// import React from "react";
import EmployeeTable from "../components/tables/EmployeeTable";
import AddAdminButton from "../components/ui/button/AddAdminButton";
import { ChevronDown, Plus } from "lucide-react";
import { Modal } from "../components/ui/modal";
import { useModal } from "../hooks/useModal";
// import ConfirmationModal from "../components/ui/modal/ConfirmationModal";
import AddEmployeeModal from "../components/ui/modal/AddEmployeeModal";
import MajorTable from "../components/tables/MajorTable";
import Label from "../components/form/Label";
import FilterGrad from "../components/myComponnets/FilterGrad";
import AddMajorModal from "../components/ui/modal/AddMajorModal";
import { useState } from "react";
import TabButtons from "../components/ui/button/TabButtons";
import SectionsTable from "../components/tables/SectionsTable";
import FilterMajors from "../components/myComponnets/FilterMajors";
import AddSectionModal from "../components/ui/modal/AddSectionModal";
import { useTheme } from "../context/ThemeContext";

function MajorsAndSectionsPage() {
  const { majorId } = useTheme();
  const { setMajorId } = useTheme();

  const { isOpen, openModal, closeModal } = useModal();
  const [toOpenModalInParentPage, setToOpenModalInParentPage] = useState("");
  const [selectedTab, setSelectedTab] = useState<"majors" | "sections">(
    "majors"
  );

  return (
    <div className="px-6  lg:px-8 lg:py-10">
      <div className="w-full flex justify-center items-center">
        <TabButtons selectedTab={selectedTab} setSelectedTab={setSelectedTab} />
      </div>

      {selectedTab === "majors" ? (
        <>
          <div className="w-full flex justify-between items-center ">
            <AddAdminButton
              endIcon={<Plus />}
              onClick={() => {
                setToOpenModalInParentPage("major"), openModal();
              }}
              className="mb-6"
            >
              Add Major
            </AddAdminButton>
            <FilterGrad />
          </div>
          <MajorTable setToOpenModalInParentPage={setToOpenModalInParentPage} />
        </>
      ) : (
        <>
          <div className="w-full flex justify-between items-center ">
            <AddAdminButton
              endIcon={<Plus />}
              onClick={() => {
                setToOpenModalInParentPage("section"), openModal();
              }}
              className="mb-6"
            >
              Add Section
            </AddAdminButton>
            <FilterMajors
              selectedMajor={majorId}
              setSelectedMajor={setMajorId}
            />
          </div>
          <SectionsTable
            setToOpenModalInParentPage={setToOpenModalInParentPage}
          />
        </>
      )}

      <Modal isOpen={isOpen} onClose={closeModal} className="max-w-[700px] ">
        {toOpenModalInParentPage === "major" ? (
          <AddMajorModal closeModal1={closeModal} action="add" />
        ) : (
          <AddSectionModal closeModal1={closeModal} action="add" />
        )}
      </Modal>
    </div>
  );
}

export default MajorsAndSectionsPage;
