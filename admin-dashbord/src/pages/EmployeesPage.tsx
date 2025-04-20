// import React from "react";
import EmployeeTable from "../components/tables/EmployeeTable";
import AddAdminButton from "../components/ui/button/AddAdminButton";
import { Plus } from "lucide-react";
import { Modal } from "../components/ui/modal";
import { useModal } from "../hooks/useModal";
// import ConfirmationModal from "../components/ui/modal/ConfirmationModal";
import AddEmployeeModal from "../components/ui/modal/AddEmployeeModal";
function EmployeesPage() {
  const { isOpen, openModal, closeModal } = useModal();
  return (
    <div>
      <AddAdminButton endIcon={<Plus />} onClick={openModal} className="mb-6">
        Add Admin
      </AddAdminButton>
      <EmployeeTable />
      <Modal isOpen={isOpen} onClose={closeModal} className="max-w-[700px] ">
        <AddEmployeeModal closeModal1={closeModal} action="add" />
      </Modal>
    </div>
  );
}

export default EmployeesPage;
